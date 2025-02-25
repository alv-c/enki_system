<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Rifas Disponíveis - {{ $campanha->nome }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto">
        <div class="mb-4 flex gap-4">
            <form action="{{ route('comprador.carrinho.adicionar.multiplas') }}" method="POST">
                @csrf
                <input type="hidden" name="campanha_id" value="{{ $campanha->id }}">

                <button type="submit" name="quantidade" value="10"
                    class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    {{ __('Adicionar +10 Rifas') }}
                </button>

                <button type="submit" name="quantidade" value="20"
                    class="bg-zinc-900 hover:bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    {{ __('Adicionar +20 Rifas') }}
                </button>

                <button type="submit" name="quantidade" value="30"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                    {{ __('Adicionar +30 Rifas') }}
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($rifas as $rifa)
                <form action="{{ route('comprador.carrinho.adicionar', $rifa->id) }}" method="POST">
                    @csrf
                    <div class="bg-white shadow-md p-4 rounded-lg">
                        <p class="font-bold text-xl text-gray-800">#{{ $rifa->numero }} - R$
                            {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
                        <button type="submit"
                            class="mt-2 inline-block bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50">
                            {{ __('Adicionar ao Carrinho +') }}
                        </button>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</x-app-layout>
