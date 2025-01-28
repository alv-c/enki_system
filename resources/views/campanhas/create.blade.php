<x-app-layout>
    <h1>Criar Campanha</h1>
    <form action="{{ route('campanhas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required class="input-text">

        <label for="subtitulo">Subtítulo:</label>
        <input type="text" name="subtitulo" class="input-text">

        <label for="descricao">Descrição:</label>
        <textarea name="descricao" rows="4" class="input-text"></textarea>

        <label for="status">Status:</label>
        <input type="radio" name="status" value="ativo" checked> Ativo
        <input type="radio" name="status" value="inativo"> Inativo

        <label for="valor_cota">Valor por Cota:</label>
        <input type="number" name="valor_cota" step="0.01" required class="input-text">

        <label for="num_cotas_disponiveis">Número de Cotas Disponíveis:</label>
        <input type="number" name="num_cotas_disponiveis" required class="input-text">

        <label for="galeria">Galeria de Imagens:</label>
        <input type="file" name="galeria[]" multiple class="input-file">

        <h2>Promoções:</h2>
        <div id="promo-container">
            <div class="promo-group">
                <label for="num_rifas[]">Número de Rifas:</label>
                <input type="number" name="num_rifas[]" required class="input-text">

                <label for="valor_plano[]">Valor do Plano:</label>
                <input type="number" name="valor_plano[]" step="0.01" required class="input-text">
            </div>
        </div>
        <button type="button" onclick="addPromo()">Adicionar Promoção</button>

        <button type="submit" class="btn btn-primary">Salvar</button>
    </form>

    <script>
        function addPromo() {
            const container = document.getElementById('promo-container');
            const newPromo = document.createElement('div');
            newPromo.classList.add('promo-group');
            newPromo.innerHTML = `
                <label for="num_rifas[]">Número de Rifas:</label>
                <input type="number" name="num_rifas[]" required class="input-text">

                <label for="valor_plano[]">Valor do Plano:</label>
                <input type="number" name="valor_plano[]" step="0.01" required class="input-text">
            `;
            container.appendChild(newPromo);
        }
    </script>
</x-app-layout>
