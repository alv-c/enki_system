<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campanhas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Botão Criar Campanha -->
            <div class="flex justify-end">
                <a href="{{ route('campanhas.create') }}"
                    class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Criar Campanha
                </a>
            </div>

            <!-- Tabela de Campanhas -->
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-700 text-gray-500 text-md">
                            <th class="px-4 py-3 text-left">Nome</th>
                            <th class="px-4 py-3 text-left">Subtítulo</th>
                            <th class="px-4 py-3 text-center">Status</th>
                            <th class="px-4 py-3 text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campanhas as $campanha)
                            <tr
                                class="border-b border-gray-700 hover:bg-gray-500 transition duration-300 text-gray-900 text-md">
                                <td class="px-4 py-3">{{ $campanha->nome }}</td>
                                <td class="px-4 py-3">{{ $campanha->subtitulo }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span
                                        class="px-2 py-1 rounded-md text-sm font-semibold 
                                        {{ $campanha->status == 'ativo' ? 'btn-bg-green text-white' : 'btn-bg-red text-white' }}">
                                        {{ $campanha->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('campanhas.show', $campanha->id) }}"
                                        class="text-blue-400 hover:text-blue-300 px-2">
                                        👁 Ver
                                    </a>
                                    <a href="{{ route('campanhas.edit', $campanha->id) }}"
                                        class="text-green-400 hover:text-green-300 px-2">
                                        ✏ Editar
                                    </a>
                                    <form action="{{ route('campanhas.destroy', $campanha->id) }}" method="POST"
                                        class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 px-2">
                                            🗑 Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>
