<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $campanha->nome }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Detalhes da Campanha -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700">Detalhes da Campanha</h3>
                <div class="mt-4 text-gray-600 space-y-2">
                    <p><strong>Subtítulo:</strong> {{ $campanha->subtitulo }}</p>
                    <p><strong>Descrição:</strong> {{ $campanha->descricao }}</p>
                    <p><strong>Status:</strong>
                        <span
                            class="px-2 py-1 rounded-md text-white 
                            {{ $campanha->status == 'ativo' ? 'bg-green-500' : 'bg-red-500' }}">
                            {{ ucfirst($campanha->status) }}
                        </span>
                    </p>
                    <p><strong>Valor por Cota:</strong> R$ {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
                    <p><strong>Cotas Disponíveis:</strong> {{ $campanha->num_cotas_disponiveis }}</p>
                </div>
            </div>

            <!-- Promoções -->
            <div class="p-6 bg-white shadow sm:rounded-lg">
                <h3 class="text-lg font-semibold text-gray-700">Promoções</h3>
                <div class="mt-4">
                    @if (!empty($campanha->planosPromocao) && $campanha->planosPromocao->count() > 0)
                        <ul class="list-disc list-inside text-gray-600 space-y-1">
                            @foreach ($campanha->planosPromocao as $promo)
                                <li>{{ $promo->num_rifas }} Rifas - R$
                                    {{ number_format($promo->valor_plano, 2, ',', '.') }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-gray-500">Nenhuma promoção cadastrada para esta campanha.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
