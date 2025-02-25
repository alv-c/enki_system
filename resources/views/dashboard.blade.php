<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <x-card-counter title="Total de Campanhas" :count="$totalCampanhas" />
                <x-card-counter title="Total de Rifas" :count="$totalRifas" />
                <x-card-counter title="Total de Planos de Promoção" :count="$totalPlanos" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-6">
                <x-card-counter title="Campanhas Ativas" :count="$campanhasAtivas" />
                <x-card-counter title="Rifas Disponíveis" :count="$rifasDisponiveis" />
            </div>
        </div>
    </div>
</x-app-layout>
