<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <h2 class="text-xl font-bold mb-4">📜 Meus Pedidos</h2>

        @if ($pedidos->isEmpty())
            <p class="text-gray-600">Você ainda não realizou nenhuma compra de rifas.</p>
        @else
            <div class="bg-white shadow-md rounded-lg p-4">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                #ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Campanha</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Números Comprados</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Data</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($pedidos as $pedido)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pedido->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pedido->campanha->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach ($pedido->rifas as $rifa)
                                        <span
                                            class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">{{ $rifa->numero }}</span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $pedido->status == 'pago' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($pedido->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $pedido->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
