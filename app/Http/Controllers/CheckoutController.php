<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class CheckoutController extends Controller
{
    // Exibe o carrinho do comprador
    public function index()
    {
        $carrinho = Session::get('carrinho', []);
        return view('comprador.carrinho', compact('carrinho'));
    }

    // Adiciona rifa ao carrinho de 1 em 1
    public function adicionarAoCarrinho(Request $request, Rifa $rifa)
    {
        $carrinho = Session::get('carrinho', []);

        // Verifica se a rifa está disponível
        if ($rifa->status !== 'disponivel') {
            return back()->with('error', 'Essa rifa já foi reservada.');
        }

        // Adiciona ao carrinho se ainda não estiver
        if (!isset($carrinho[$rifa->id])) {
            $carrinho[$rifa->id] = [
                'numero' => $rifa->numero,
                'valor' => $rifa->campanha->valor_cota
            ];
        }

        Session::put('carrinho', $carrinho);

        return back()->with('success', 'Rifa adicionada ao carrinho!');
    }

    // Adiciona rifa ao carrinho em massa
    public function adicionarMultiplasAoCarrinho(Request $request)
    {
        $request->validate([
            'campanha_id' => 'required|exists:campanhas,id',
            'quantidade' => 'required|integer|min:1',
        ]);

        $campanhaId = $request->campanha_id;
        $quantidade = $request->quantidade;

        // Buscar rifas disponíveis da campanha, de forma aleatória
        $rifasDisponiveis = Rifa::where('id_campanha', $campanhaId)
            ->where('status', 'disponivel')
            ->inRandomOrder()
            ->limit($quantidade)
            ->get();

        // Verifica se há rifas disponíveis suficientes
        if ($rifasDisponiveis->count() < $quantidade) {
            return back()->with('error', 'Quantidade de rifas disponíveis insuficiente.');
        }

        // Recuperar o carrinho da sessão
        $carrinho = Session::get('carrinho', []);

        // Adicionar rifas ao carrinho
        foreach ($rifasDisponiveis as $rifa) {
            if (!isset($carrinho[$rifa->id])) {
                $carrinho[$rifa->id] = [
                    'numero' => $rifa->numero,
                    'valor' => $rifa->campanha->valor_cota,
                ];
            }
        }

        // Atualizar o carrinho na sessão
        Session::put('carrinho', $carrinho);
        return back()->with('success', "$quantidade rifas adicionadas ao carrinho!");
    }

    public function removerDoCarrinho($id)
    {
        $carrinho = Session::get('carrinho', []);
        unset($carrinho[$id]);
        Session::put('carrinho', $carrinho);
        return back()->with('success', 'Rifa removida do carrinho.');
    }

    // Finaliza a compra e cria um pedido
    public function finalizarCompra(Request $request)
    {
        $user = Auth::user();
        $carrinho = Session::get('carrinho', []);

        if (empty($carrinho)) {
            return redirect()->route('comprador.carrinho')->with('error', 'Seu carrinho está vazio.');
        }

        $request->validate([
            'cpf' => 'required|string|max:14',
            'telefone' => 'required|string|max:15',
        ]);

        DB::beginTransaction();
        try {
            // Pega o primeiro item do carrinho
            $primeiraRifaId = array_key_first($carrinho);
            $primeiraRifa = Rifa::with('campanha')->find($primeiraRifaId);

            if (!$primeiraRifa || !$primeiraRifa->campanha) {
                DB::rollBack();
                return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar a compra: Rifa ou Campanha não encontrada.');
            }

            $valorTotal = $primeiraRifa->campanha->valor_cota * count($carrinho);
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'campanha_id' => $primeiraRifa->campanha->id,
                'status' => 'pendente',
                'valor_a_pagar' => $valorTotal
            ]);

            if (!$pedido) {
                DB::rollBack();
                return redirect()->route('comprador.carrinho')->with('error', 'Erro ao criar o pedido.');
            }

            Rifa::whereIn('id', array_keys($carrinho))->update([
                'id_comprador' => $user->id,
                'status' => 'reservada',
                'pedido_id' => $pedido->id,
            ]);
            DB::commit();

            $resultadoPagamento = $this->processarPagamento($pedido, $request->cpf, $request->telefone);

            if ($resultadoPagamento['status'] === 'sucesso') {
                return redirect()->route('carrinho.qrcode', ['pedido' => $pedido->id]);
            } else {
                // Se o pagamento falhar, desfaz a reserva das rifas
                Rifa::whereIn('id', array_keys($carrinho))->update([
                    'id_comprador' => null,
                    'status' => 'disponivel',
                    'pedido_id' => null,
                ]);
                return redirect()->route('comprador.carrinho')->with('error', $resultadoPagamento['mensagem']);
            }


            // if ($resultadoPagamento['status'] == 'sucesso') {
            //     // Atualiza o status do pedido e o valor pago
            //     $pedido->update([
            //         'status' => 'pago',
            //         'valor_pago' => $resultadoPagamento['valor_pago'], // Valor pago recebido da API
            //     ]);

            //     // Limpa o carrinho após a compra
            //     Session::forget('carrinho');

            //     DB::commit();

            //     return redirect()->route('comprador.meus-pedidos')->with('success', 'Pedido realizado com sucesso! Pagamento confirmado.');
            // } else {
            //     DB::rollBack();
            //     return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar o pagamento.');
            // }



        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao finalizar compra: ' . $e->getMessage());
            return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar o pedido.');
        }
    }

    public function calcularValorTotal(array $carrinho)
    {
        $total = 0;
        foreach ($carrinho as $rifaId => $item) {
            $valorUnitario = (float) $item['valor'];
            $numeroRifa = (int) $item['numero'];
            $total += $valorUnitario;
        }
        return number_format($total, 2, '.', '');
    }

    public function processarPagamento(Pedido $pedido, $cpf, $telefone)
    {
        $apiToken = config('services.fastsoft.api_token');
        $apiUrl = config('services.fastsoft.api_url');

        // Recarrega as relações do pedido para evitar valores nulos
        $pedido->load(['user', 'rifas']);

        // Valida se o pedido tem um usuário associado
        if (!$pedido->user) {
            return [
                'status' => 'erro',
                'mensagem' => 'Pedido sem usuário associado.',
            ];
        }

        $valorTotal = $pedido->calcularValorTotal() * 100;

        $dadosPagamento = [
            "amount" => $valorTotal,
            "paymentMethod" => "PIX",
            "customer" => [
                "name" => $pedido->user->name,
                "email" => $pedido->user->email,
                "document" => [
                    "number" => preg_replace('/\D/', '', $cpf),
                    "type" => "CPF"
                ],
                "phone" => preg_replace('/\D/', '', $telefone),
                "externaRef" => (string) $pedido->id
            ],
            "shipping" => [
                "fee" => 100,
                "address" => [
                    "street" => "Avenida Paulista",
                    "streetNumber" => "1000",
                    "complement" => "Apartamento 101",
                    "zipCode" => "01310-000",
                    "neighborhood" => "Bela Vista",
                    "city" => "São Paulo",
                    "state" => "SP",
                    "country" => "BR"
                ]
            ],
            "items" => [
                [
                    "title" => "Venda de infoprodutos",
                    "unitPrice" => $pedido->campanha->valor_cota * 100,
                    "quantity" => $pedido->rifas()->where('id_comprador', $pedido->user->id)->count(),
                    "tangible" => false,
                    "externalRef" => (string) $pedido->id
                ]
            ],
            "pix" => [
                "expiresInDays" => 1
            ],
            "postbackUrl" => "https://webhook.site/efd8a996-67fc-4947-82df-1e2cbec74f91",
            "metadata" => "{postback:https://webhook.site/ac9cbb8f-3dec-445a-bdff-3bc7f98ccf29}",
            "traceable" => false
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => $apiToken,
                'Content-Type' => 'application/json'
            ])->post($apiUrl, $dadosPagamento);

            if ($response->successful()) {
                $dadosResposta = $response->json();

                if (isset($dadosResposta['data']['pix']['qrcode'])) {
                    $qrcodeUrl = $dadosResposta['data']['pix']['qrcode'];

                    $pedido->update([
                        'qrcode_url' => $qrcodeUrl,
                    ]);

                    return [
                        'status' => 'sucesso',
                        'qrcode_url' => $qrcodeUrl,
                    ];
                } else {
                    return [
                        'status' => 'erro',
                        'mensagem' => 'QR Code não disponível na resposta da API.',
                    ];
                }
            } else {
                return [
                    'status' => 'erro',
                    'mensagem' => 'Erro na comunicação com a API de pagamento.',
                    'detalhes' => $response->json(),
                ];
            }
        } catch (\Exception $e) {
            Log::error('Erro no processamento do pagamento: ' . $e->getMessage());
            return [
                'status' => 'erro',
                'mensagem' => 'Erro interno ao processar o pagamento.',
            ];
        }
    }

    public function exibirQrCode(Pedido $pedido)
    {
        if (!$pedido->qrcode_url) {
            return redirect()->route('comprador.carrinho')->with('error', 'QR Code não disponível para este pedido.');
        }
        return view('carrinho.qrcode', compact('pedido'));
    }
}
