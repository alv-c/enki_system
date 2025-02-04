<x-app-layout>
    <div class="py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($campanhas as $campanha)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <h3 class="text-lg font-bold">{{ $campanha->nome }}</h3>
                    <p>{{ $campanha->subtitulo }}</p>
                    <p>Valor da Cota: R$ {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
                    <a href="{{ route('comprador.campanha.rifas', $campanha->id) }}"
                        class="mt-2 text-white px-4 py-2 rounded" style="background: forestgreen;">
                        Ver Rifas
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
