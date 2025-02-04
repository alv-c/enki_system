<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rifas Disponíveis - {{ $campanha->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="grid grid-cols-4 gap-4">
            @foreach ($rifas as $rifa)
                <form action="{{ route('comprador.carrinho.adicionar', $rifa->id) }}" method="POST">
                    @csrf
                    <div class="bg-white shadow-md p-4 rounded">
                        <p class="font-bold text-xl">#{{ $rifa->numero }} - R$
                            {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
                        <button type="submit" style="background: red" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                            Adicionar ao Carrinho +
                        </button>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</x-app-layout>
