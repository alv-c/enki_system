<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Campanha') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <form action="{{ route('campanhas.update', $campanha->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="nome" class="block font-medium text-sm text-gray-700">Nome:</label>
                            <input type="text" name="nome" value="{{ $campanha->nome }}" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="subtitulo" class="block font-medium text-sm text-gray-700">Subtítulo:</label>
                            <input type="text" name="subtitulo" value="{{ $campanha->subtitulo }}"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="descricao" class="block font-medium text-sm text-gray-700">Descrição:</label>
                            <textarea name="descricao" rows="4"
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">{{ $campanha->descricao }}</textarea>
                        </div>
                        <div>
                            <label class="block font-medium text-sm text-gray-700">Status:</label>
                            <div class="flex items-center gap-4 mt-1">
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="ativo"
                                        {{ $campanha->status == 'ativo' ? 'checked' : '' }} class="text-indigo-600">
                                    <span class="ml-2 text-gray-700">Ativo</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="status" value="inativo"
                                        {{ $campanha->status == 'inativo' ? 'checked' : '' }} class="text-indigo-600">
                                    <span class="ml-2 text-gray-700">Inativo</span>
                                </label>
                            </div>
                        </div>
                        <div>
                            <label for="valor_cota" class="block font-medium text-sm text-gray-700">Valor por
                                Cota:</label>
                            <input type="number" name="valor_cota" step="0.01" value="{{ $campanha->valor_cota }}"
                                required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="num_cotas_disponiveis" class="block font-medium text-sm text-gray-700">Número de
                                Cotas Disponíveis:</label>
                            <input type="number" name="num_cotas_disponiveis"
                                value="{{ $campanha->num_cotas_disponiveis }}" required
                                class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <div>
                            <label for="galeria" class="block font-medium text-sm text-gray-700">Galeria de
                                Imagens:
                            </label>
                            <input type="file" name="galeria" multiple>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                                Atualizar Campanha
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
