<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('comprador.campanhas') }}" class="text-lg font-bold text-gray-800">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo"
                        style="width: 100%; max-width: 40px; object-fit: cover;">
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden sm:flex space-x-6">
                <x-nav-link :href="route('comprador.campanhas')" :active="request()->routeIs('comprador.campanhas')">
                    {{ __('Campanhas') }}
                </x-nav-link>
                <x-nav-link :href="route('comprador.campanhas')" :active="request()->routeIs('comprador.campanhas')">
                    {{ __('Minhas Rifas') }}
                </x-nav-link>
                <x-nav-link :href="route('comprador.carrinho')" :active="request()->routeIs('comprador.carrinho')">
                    {{ __('Carrinho') }}
                </x-nav-link>
                <x-nav-link :href="route('comprador.meus-pedidos')" :active="request()->routeIs('comprador.meus-pedidos')">
                    {{ __('Meus Pedidos') }}
                </x-nav-link>
            </div>

            <!-- User Dropdown -->
            <div class="hidden sm:flex items-center space-x-4">
                <span class="text-gray-600 text-sm">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="ml-4">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm">
                        {{ __('Sair') }}
                    </button>
                </form>
            </div>

            <!-- Mobile Menu Button -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="text-gray-600 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'block': !open }" class="block" d="M4 6h16M4 12h16M4 18h16">
                        </path>
                        <path :class="{ 'hidden': !open, 'block': open }" class="hidden" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden bg-gray-800 text-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('comprador.campanhas')" :active="request()->routeIs('comprador.campanhas')">
                {{ __('Campanhas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('comprador.carrinho')" :active="request()->routeIs('comprador.carrinho')">
                🛒 {{ __('Carrinho') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('comprador.meus-pedidos')" :active="request()->routeIs('comprador.meus-pedidos')">
                📜 {{ __('Meus Pedidos') }}
            </x-responsive-nav-link>
        </div>
        <div class="border-t border-gray-700 pt-4 pb-1">
            <div class="px-4">
                <div class="text-white font-medium text-base">{{ Auth::user()->name }}</div>
                <div class="text-gray-400 text-sm">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">{{ __('Perfil') }}</x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        🚪 {{ __('Sair') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
