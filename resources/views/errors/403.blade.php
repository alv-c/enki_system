<x-app-layout>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold">Acesso Negado</h1>
                <p class="mt-2">Você não tem permissão para acessar esta área.</p>
                <a href="{{ route('dashboard') }}" class="text-blue-500 underline mt-4">Voltar para o dashboard</a>
            </div>
        </div>
    </div>
</x-app-layout>
