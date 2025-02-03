<x-app-layout>
    <h1>{{ $campanha->nome }}</h1>
    <p><strong>Subtítulo:</strong> {{ $campanha->subtitulo }}</p>
    <p><strong>Descrição:</strong> {{ $campanha->descricao }}</p>
    <p><strong>Status:</strong> {{ $campanha->status }}</p>
    <p><strong>Valor por Cota:</strong> R$ {{ number_format($campanha->valor_cota, 2, ',', '.') }}</p>
    <p><strong>Cotas Disponíveis:</strong> {{ $campanha->num_cotas_disponiveis }}</p>

    <h2>Promoções</h2>
    <ul>
        @if (!empty($campanha->planosPromocao) && $campanha->planosPromocao->count() > 0)
            @foreach ($campanha->planosPromocao as $promo)
                <li>{{ $promo->num_rifas }} Rifas - R$ {{ number_format($promo->valor_plano, 2, ',', '.') }}</li>
            @endforeach
        @else
            <li>Nenhuma promoção cadastrada para esta campanha.</li>
        @endif
    </ul>
</x-app-layout>
