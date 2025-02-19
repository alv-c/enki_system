<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Pedido;

/**
 * Configurar o Webhook na API da FastSoft Brasil
 * registrar a URL do webhook no painel da FastSoft Brasil, para 
 * que eles enviem notificações para https://seusite.com/api/webhook/pagamento 
 * sempre que o status do pagamento mudar.
 * SITE: https://developers.fastsoftbrasil.com
 */

class PagamentoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        Log::info('Webhook recebido', $request->all()); // Log para depuração

        $data = $request->validate([
            'transaction_id' => 'required|string',
            'status' => 'required|string',
            'pedido_id' => 'required|integer|exists:pedidos,id',
        ]);

        // Busca o pedido no banco de dados
        $pedido = Pedido::find($data['pedido_id']);

        if (!$pedido) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        if ($data['status'] === 'confirmed') {
            $pedido->update([
                'status' => 'pago',
                'valor_pago' => $pedido->valor_a_pagar,
            ]);

            return response()->json(['message' => 'Status do pedido atualizado para pago'], 200);
        }

        return response()->json(['message' => 'Nenhuma alteração necessária'], 200);
    }
}
