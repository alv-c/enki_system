<x-app-layout>
    <h1>Rifas para a campanha: {{ $campanha->nome }}</h1>
    <form action="{{ route('rifas.store') }}" method="POST">
        @csrf
        <input type="hidden" name="campanha_id" value="{{ $campanha->id }}">
        <label for="numero">Número da Rifa:</label>
        <input type="number" name="numero" required>
        <button type="submit">Reservar Rifa</button>
    </form>

    <h2>Rifas Reservadas</h2>
    <ul>
        @foreach ($rifas as $rifa)
            <li>{{ $rifa->numero }} - {{ $rifa->status }}</li>
        @endforeach
    </ul>
</x-app-layout>