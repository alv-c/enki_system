<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rifa;
use App\Models\Pedido;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    // Exibe o carrinho do comprador
    public function index()
    {
        $carrinho = Session::get('carrinho', []);
        return view('comprador.carrinho', compact('carrinho'));
    }

    // Adiciona uma rifa ao carrinho
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

    // Remove uma rifa do carrinho
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

        DB::beginTransaction();

        try {
            // Pega o primeiro item do carrinho
            $primeiraRifaId = array_key_first($carrinho);
            $primeiraRifa = Rifa::with('campanha')->find($primeiraRifaId);

            if (!$primeiraRifa || !$primeiraRifa->campanha) {
                return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar a compra: Rifa ou Campanha não encontrada.');
            }

            // Cria o pedido
            $pedido = Pedido::create([
                'user_id' => $user->id,
                'campanha_id' => $primeiraRifa->campanha->id,
                'status' => 'pendente',
                'valor_a_pagar' => $this->calcularValorTotal($carrinho), // Método para calcular o valor total
            ]);

            // Atualiza as rifas como "reservadas" e vincula ao pedido
            Rifa::whereIn('id', array_keys($carrinho))->update([
                'id_comprador' => $user->id,
                'status' => 'reservada',
                'pedido_id' => $pedido->id,
            ]);

            /**
             * ================ INTEGRAR COM API DE PAGAMENTO ================
             */
            // Chama o serviço de pagamento (Exemplo com PayPal ou Stripe)
            $resultadoPagamento = $this->processarPagamento($pedido, $request); // Método que integra com a API de pagamento

            if ($resultadoPagamento['status'] == 'sucesso') {
                // Atualiza o status do pedido e o valor pago
                $pedido->update([
                    'status' => 'pago',
                    'valor_pago' => $resultadoPagamento['valor_pago'], // Valor pago recebido da API
                ]);

                // Limpa o carrinho após a compra
                Session::forget('carrinho');

                DB::commit();

                return redirect()->route('comprador.meus-pedidos')->with('success', 'Pedido realizado com sucesso! Pagamento confirmado.');
            } else {
                DB::rollBack();
                return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar o pagamento.');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Erro ao finalizar compra: ' . $e->getMessage());
            return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar o pedido.');
        }
    }

    //ANTIGO
    // public function finalizarCompra(Request $request)
    // {
    //     $user = Auth::user();
    //     $carrinho = Session::get('carrinho', []);

    //     if (empty($carrinho)) {
    //         return redirect()->route('comprador.carrinho')->with('error', 'Seu carrinho está vazio.');
    //     }

    //     DB::beginTransaction();

    //     try {
    //         // Pega o primeiro item do carrinho
    //         $primeiraRifaId = array_key_first($carrinho);
    //         $primeiraRifa = Rifa::with('campanha')->find($primeiraRifaId);


    //         if (!$primeiraRifa) {
    //             return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar a compra: Rifa não encontrada.');
    //         }

    //         if (!$primeiraRifa->campanha) {
    //             return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar a compra: Campanha não encontrada.');
    //         }

    //         // Cria o pedido associando à campanha da rifa
    //         $pedido = Pedido::create([
    //             'user_id' => $user->id,
    //             'campanha_id' => $primeiraRifa->campanha->id, // Agora garantido que não será null
    //             'status' => 'pendente',
    //         ]);


    //         // Atualiza as rifas como "reservadas" e vincula ao pedido
    //         Rifa::whereIn('id', array_keys($carrinho))->update([
    //             'id_comprador' => $user->id,
    //             'status' => 'reservada',
    //             'pedido_id' => $pedido->id
    //         ]);

    //         // Limpa o carrinho após a compra
    //         Session::forget('carrinho');

    //         DB::commit();

    //         return redirect()->route('comprador.meus-pedidos')->with('success', 'Pedido realizado com sucesso! Aguarde o pagamento.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         Log::error('Erro ao finalizar compra: ' . $e->getMessage());
    //         return redirect()->route('comprador.carrinho')->with('error', 'Erro ao processar o pedido.');
    //     }
    // }

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

    // EXEMPLO INTEGRAÇÃO CHECKOUT PAYPAL
    public function processarPagamento(Pedido $pedido, Request $request)
    {
        // $valorTotal = $pedido->valor_a_pagar;

        // try {
        //     // Exemplo com PayPal
        //     $paypal = new \PayPal\Rest\ApiContext(
        //         new \PayPal\Auth\OAuthTokenCredential(
        //             'YOUR_CLIENT_ID',
        //             'YOUR_SECRET_KEY'
        //         )
        //     );

        //     // Criar o pagamento
        //     $payment = new \PayPal\Api\Payment();
        //     $payment->setIntent('sale')
        //         ->setPayer(new \PayPal\Api\Payer(['payment_method' => 'credit_card']))
        //         ->setTransactions([new \PayPal\Api\Transaction([
        //             'amount' => new \PayPal\Api\Amount(['total' => $valorTotal, 'currency' => 'BRL']),
        //             'description' => 'Compra de Rifa'
        //         ])]);

        //     // Executa o pagamento
        //     $payment->create($paypal);

        //     // Verifica o status
        //     if ($payment->getState() == 'approved') {
        //         return [
        //             'status' => 'sucesso',
        //             'valor_pago' => $valorTotal, // Valor pago via PayPal
        //         ];
        //     }

        //     return [
        //         'status' => 'erro',
        //         'mensagem' => 'Pagamento não aprovado pelo PayPal.',
        //     ];
        // } catch (\Exception $e) {
        //     Log::error('Erro no processamento do pagamento com PayPal: ' . $e->getMessage());
        //     return [
        //         'status' => 'erro',
        //         'mensagem' => 'Erro no processamento do pagamento.',
        //     ];
        // }

        //APAGAR
        return [
            'status' => 'sucesso',
            'valor_pago' => '1000', // Valor pago via PayPal
        ];
    }
}
