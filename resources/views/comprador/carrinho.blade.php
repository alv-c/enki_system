<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        {{-- Verifica se o carrinho tem rifas --}}
        @if (!empty($carrinho) && count($carrinho) > 0)
            <table class="w-full border-collapse border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border px-4 py-2">Número</th>
                        <th class="border px-4 py-2">Valor</th>
                        <th class="border px-4 py-2">Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carrinho as $id => $item)
                        {{-- Busca a rifa com o número --}}
                        @php
                            $rifa = \App\Models\Rifa::find($id);
                        @endphp
                        @if ($rifa)
                            {{-- Verifica se a rifa foi encontrada --}}
                            <tr>
                                <td class="border px-4 py-2">{{ $item['numero'] }}</td>
                                <td class="border px-4 py-2">R$ {{ number_format($item['valor'], 2, ',', '.') }}</td>
                                <td class="border px-4 py-2">
                                    <form action="{{ route('comprador.carrinho.remover', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500">Remover</button>
                                    </form>
                                </td>
                            </tr>
                        @else
                            {{-- Caso a rifa não seja encontrada --}}
                            <tr>
                                <td class="border px-4 py-2" colspan="3">Rifa não encontrada.</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>

            {{-- Botão para finalizar compra --}}
            <div class="mt-4">
                <form action="{{ route('comprador.checkout.processar') }}" method="POST">
                    @csrf
                    <button type="submit" style="background: red" class="bg-green-500 text-white px-4 py-2 rounded">
                        Finalizar Compra
                    </button>
                </form>
            </div>
        @else
            <p>Seu carrinho está vazio.</p>
        @endif
    </div>
</x-app-layout>
