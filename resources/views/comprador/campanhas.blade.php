<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($campanhas as $campanha)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold text-gray-800">{{ $campanha->nome }}</h3>
                    <p class="text-gray-600">{{ $campanha->subtitulo }}</p>
                    <p class="text-gray-800">Valor da Cota: R$ {{ number_format($campanha->valor_cota, 2, ',', '.') }}
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('comprador.campanha.rifas', $campanha->id) }}"
                            class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                            {{ __('Ver Rifas') }}
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
