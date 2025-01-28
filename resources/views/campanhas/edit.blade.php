<x-app-layout>
    <h1>Editar Campanha</h1>
    <form action="{{ route('campanhas.update', $campanha->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="nome">Nome:</label>
        <input type="text" name="nome" value="{{ $campanha->nome }}" required class="input-text">

        <label for="subtitulo">Subtítulo:</label>
        <input type="text" name="subtitulo" value="{{ $campanha->subtitulo }}" class="input-text">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" rows="4" class="input-text">{{ $campanha->descricao }}</textarea>

        <label for="status">Status:</label>
        <input type="radio" name="status" value="ativo" {{ $campanha->status == 'ativo' ? 'checked' : '' }}> Ativo
        <input type="radio" name="status" value="inativo" {{ $campanha->status == 'inativo' ? 'checked' : '' }}>
        Inativo

        <label for="valor_cota">Valor por Cota:</label>
        <input type="number" name="valor_cota" step="0.01" value="{{ $campanha->valor_cota }}" required
            class="input-text">

        <label for="num_cotas_disponiveis">Número de Cotas Disponíveis:</label>
        <input type="number" name="num_cotas_disponiveis" value="{{ $campanha->num_cotas_disponiveis }}" required
            class="input-text">

        <label for="galeria">Galeria de Imagens:</label>
        <input type="file" name="galeria[]" multiple class="input-file">

        <button type="submit" class="btn btn-primary">Atualizar</button>
    </form>
</x-app-layout>
