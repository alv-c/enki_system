<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container mx-auto mt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card: Total de Campanhas -->
            <x-card-counter title="Total de Campanhas" :count="$totalCampanhas" />

            <!-- Card: Total de Rifas -->
            <x-card-counter title="Total de Rifas" :count="$totalRifas" />

            <!-- Card: Total de Planos de Promoção -->
            <x-card-counter title="Total de Planos de Promoção" :count="$totalPlanos" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-4">
            <!-- Card: Campanhas Ativas -->
            <x-card-counter title="Campanhas Ativas" :count="$campanhasAtivas" />

            <!-- Card: Rifas Disponíveis -->
            <x-card-counter title="Rifas Disponíveis" :count="$rifasDisponiveis" />
        </div>
    </div>
</x-app-layout>
