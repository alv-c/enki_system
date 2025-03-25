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
        Log::info('Webhook recebido', $request->all());

        $data = $request->validate([
            'transaction_id' => 'required|string',
            'status' => 'required|string',
            'id' => 'required|integer',
            'pix.qrcode' => 'required|string',
        ]);

        $pedido = Pedido::find($data['id']);

        // Verifica se o pedido foi encontrado
        if (!$pedido) {
            return response()->json(['error' => 'Pedido não encontrado'], 404);
        }

        $pedido->update([
            'qrcode_url' => $data['pix']['qrcode'],
            'status' => 'pendente',
        ]);

        return response()->json(['message' => 'Pedido atualizado com QR Code'], 200);
    }
}
