<x-app-layout>
    <div class="container mx-auto mt-8">
        <h2 class="text-2xl font-bold mb-4">Finalizar Compra</h2>

        @if (session('error'))
            <div class="bg-red-500 text-white p-3 mb-4">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="bg-green-500 text-white p-3 mb-4">{{ session('success') }}</div>
        @endif

        <div class="bg-white p-4 shadow rounded">
            <h3 class="text-lg font-semibold">Resumo do Pedido</h3>
            <ul>
                @foreach ($carrinho as $item)
                    <li class="border-b py-2">Rifa #{{ $item['numero'] }} - R$
                        {{ number_format($item['valor'], 2, ',', '.') }}</li>
                @endforeach
            </ul>

            <form action="{{ route('comprador.checkout.processar') }}" method="POST" class="mt-4">
                @csrf
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Confirmar Compra</button>
            </form>
        </div>
    </div>
</x-app-layout>
