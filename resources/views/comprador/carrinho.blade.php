<x-app-layout>
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
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-4 py-2 text-left">Número</th>
                            <th class="border px-4 py-2 text-left">Valor</th>
                            <th class="border px-4 py-2 text-left">Ação</th>
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
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 focus:outline-none">
                                            Remover
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Exibir o total --}}
            <div class="mt-4 text-lg font-semibold">
                Total: R$ {{ number_format($total, 2, ',', '.') }}
            </div>

            {{-- Botão para finalizar compra --}}
            <div class="mt-4">
                <button type="button"
                    class="w-full bg-red-600 text-white py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50"
                    data-bs-toggle="modal" data-bs-target="#modalDadosPagamento">
                    Finalizar Compra
                </button>
            </div>
        @else
            <p class="text-gray-800">Seu carrinho está vazio.</p>
        @endif
    </div>

    <script>
        // Obter os elementos do modal e dos botões
        const modal = document.getElementById('modal');
        const openModalButton = document.getElementById('openModalButton');
        const closeModalButton = document.getElementById('closeModalButton');
        const cancelButton = document.getElementById('cancelButton');

        // Função para abrir o modal
        openModalButton.addEventListener('click', () => {
            modal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100', 'pointer-events-auto'); // Adiciona opacidade e habilita eventos
        });

        // Função para fechar o modal
        closeModalButton.addEventListener('click', () => {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none'); // Remove a opacidade e desabilita os eventos
            setTimeout(() => modal.classList.add('hidden'), 300); // Oculta após a animação de transição
        });

        cancelButton.addEventListener('click', () => {
            modal.classList.remove('opacity-100', 'pointer-events-auto');
            modal.classList.add('opacity-0', 'pointer-events-none');
            setTimeout(() => modal.classList.add('hidden'), 300); // Oculta após a animação de transição
        });
    </script>
</x-app-layout>
