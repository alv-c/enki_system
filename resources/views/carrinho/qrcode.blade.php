<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pagamento via PIX
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6 text-center">
                <h1 class="text-2xl font-bold mb-4">Escaneie o QR Code para realizar o pagamento</h1>

                <div class="flex justify-center my-6">
                    {!! QrCode::size(250)->generate($pedido->qrcode_url) !!}
                </div>

                <p class="text-gray-600">Caso tenha problemas, copie e cole este código no seu aplicativo bancário:</p>
                <div class="bg-gray-200 p-3 rounded mt-2 text-sm font-mono break-words">
                    {{ $pedido->qrcode_url }}
                </div>

                <a href="{{ route('comprador.meus-pedidos') }}"
                    class="mt-6 inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Ir para Meus Pedidos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
