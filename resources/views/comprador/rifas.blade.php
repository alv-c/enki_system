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

                <button type="submit" name="quantidade" value="10" style="background: dodgerblue;"
                    class="bg-blue-500 text-white px-4 py-2 rounded">
                    Adicionar +10 Rifas
                </button>

                <button type="submit" name="quantidade" value="20" style="background: dodgerblue;"
                    class="bg-green-500 text-white px-4 py-2 rounded">
                    Adicionar +20 Rifas
                </button>

                <button type="submit" name="quantidade" value="30" style="background: dodgerblue;"
                    class="bg-red-500 text-white px-4 py-2 rounded">
                    Adicionar +30 Rifas
                </button>
            </form>
        </div>

        <div class="grid grid-cols-4 gap-4">
            @foreach ($rifas as $rifa)
                <form action="{{ route('comprador.carrinho.adicionar', $rifa->id) }}" method="POST">
                    @csrf
                    <div class="bg-white shadow-md p-4 rounded">
                        <p class="font-bold text-xl">#{{ $rifa->numero }} - R$
                            {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
                        <button type="submit" style="background: red"
                            class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">
                            Adicionar ao Carrinho +
                        </button>
                    </div>
                </form>
            @endforeach
        </div>
    </div>
</x-app-layout>
