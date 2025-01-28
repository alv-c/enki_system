<x-app-layout>
    <h1>Campanhas</h1>
    <a href="{{ route('campanhas.create') }}" class="btn btn-primary">Criar Campanha</a>

    <table class="table-auto w-full">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Subtítulo</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($campanhas as $campanha)
                <tr>
                    <td>{{ $campanha->nome }}</td>
                    <td>{{ $campanha->subtitulo }}</td>
                    <td>{{ $campanha->status }}</td>
                    <td>
                        <a href="{{ route('campanhas.show', $campanha->id) }}" class="text-blue-500">Ver</a> |
                        <a href="{{ route('campanhas.edit', $campanha->id) }}" class="text-green-500">Editar</a> |
                        <form action="{{ route('campanhas.destroy', $campanha->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500">Excluir</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
