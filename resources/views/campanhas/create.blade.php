<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Criar Campanha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('campanhas.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-6">
                        @csrf

                        <!-- Nome -->
                        <div>
                            <label for="nome" class="block font-medium text-sm text-gray-700">Nome:</label>
                            <input type="text" name="nome" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Subtítulo -->
                        <div>
                            <label for="subtitulo" class="block font-medium text-sm text-gray-700">Subtítulo:</label>
                            <input type="text" name="subtitulo"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Descrição -->
                        <div>
                            <label for="descricao" class="block font-medium text-sm text-gray-700">Descrição:</label>
                            <textarea name="descricao" rows="4"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Status:</label>
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="ativo" checked class="text-indigo-600">
                                    <span class="ml-2 text-gray-700">Ativo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="inativo" class="text-indigo-600">
                                    <span class="ml-2 text-gray-700">Inativo</span>
                                </label>
                            </div>
                        </div>

                        <!-- Valor por Cota -->
                        <div>
                            <label for="valor_cota" class="block font-medium text-sm text-gray-700">Valor por
                                Cota:</label>
                            <input type="number" name="valor_cota" step="0.01" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Número de Cotas Disponíveis -->
                        <div>
                            <label for="num_cotas_disponiveis" class="block font-medium text-sm text-gray-700">Número de
                                Cotas Disponíveis:</label>
                            <input type="number" name="num_cotas_disponiveis" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Galeria de Imagens -->
                        <div>
                            <label for="galeria" class="block font-medium text-sm text-gray-700">Galeria de
                                Imagens:</label>
                            <input type="file" name="galeria[]" multiple
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Promoções -->
                        <div class="p-4 bg-gray-100 border rounded-md">
                            <h3 class="text-lg font-semibold text-gray-700">Promoções</h3>
                            <div id="promo-container" class="mt-4 space-y-4">
                                <div class="promo-group flex gap-4">
                                    <div class="w-1/2">
                                        <label class="block font-medium text-sm text-gray-700">Número de Rifas:</label>
                                        <input type="number" name="num_rifas[]" required
                                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                    <div class="w-1/2">
                                        <label class="block font-medium text-sm text-gray-700">Valor do Plano:</label>
                                        <input type="number" name="valor_plano[]" step="0.01" required
                                            class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addPromo()"
                                class="mt-4 bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                                Adicionar Promoção
                            </button>
                        </div>

                        <!-- Botão de Salvar -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                                Salvar Campanha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addPromo() {
            const container = document.getElementById('promo-container');
            const newPromo = document.createElement('div');
            newPromo.classList.add('promo-group', 'flex', 'gap-4', 'mt-2');
            newPromo.innerHTML = `
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">Número de Rifas:</label>
                    <input type="number" name="num_rifas[]" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div class="w-1/2">
                    <label class="block font-medium text-sm text-gray-700">Valor do Plano:</label>
                    <input type="number" name="valor_plano[]" step="0.01" required
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                </div>
            `;
            container.appendChild(newPromo);
        }
    </script>
</x-app-layout>
