<x-app-layout>
    <!-- Modal para CPF e Telefone -->
    <div class="modal fade" id="modalDadosPagamento" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Informe seus dados</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <form id="formPagamento" method="POST" action="{{ route('comprador.checkout.processar') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Confirmar Compra</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-6 max-w-7xl mx-auto">
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
                    @php
                        $total = 0;
                    @endphp
                    @foreach ($carrinho as $id => $item)
                        @php
                            $rifa = \App\Models\Rifa::find($id);
                            if ($rifa) {
                                $total += $item['valor'];
                            }
                        @endphp
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
                    @endforeach
                </tbody>
            </table>

            {{-- Exibir o total --}}
            <div class="mt-4 text-lg font-bold">
                Total: R$ {{ number_format($total, 2, ',', '.') }}
            </div>

            {{-- Botão para finalizar compra --}}
            <div class="mt-4">
                <button type="button" class="btn btn-success w-100" style="background: red" data-bs-toggle="modal"
                    data-bs-target="#modalDadosPagamento">
                    Finalizar Compra
                </button>
            </div>
        @else
            <p>Seu carrinho está vazio.</p>
        @endif
    </div>
</x-app-layout>
