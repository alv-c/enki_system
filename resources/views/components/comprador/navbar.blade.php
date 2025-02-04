<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('comprador.campanhas') }}" class="text-lg font-bold text-gray-800">
                        🎟️ Minhas Rifas
                    </a>
                </div>
                <div class="hidden sm:-my-px sm:ml-6 sm:flex">
                    <a href="{{ route('comprador.campanhas') }}"
                        class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">
                        Campanhas
                    </a>
                    <a href="{{ route('comprador.carrinho') }}"
                        class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">
                        🛒 Carrinho
                    </a>
                    <a href="{{ route('comprador.meus-pedidos') }}"
                        class="text-gray-600 hover:text-gray-800 px-3 py-2 rounded-md text-sm font-medium">
                        📜 Meus Pedidos
                    </a>
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center">
                <span class="text-gray-600 text-sm">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                        🚪 Sair
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
