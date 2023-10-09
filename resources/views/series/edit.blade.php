<x-layout title="Editar Série: {!! $series->nome !!}">

    <form action="{{ route('series.update', $series->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-8">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text"
                id="nome"
                name="nome"
                class="form-control"
                value="{{ $series->nome }}">
            </div>

            <div class="col-2">
                <label for="seasonsQty" class="form-label">Nº Temporadas:</label>
                <input type="text"
                    id="seasonsQty"
                    name="seasonsQty"
                    class="form-control"
                    value="{{ $series->seasons()->get()->count(); }}">
            </div>

            <div class="col-2">
                <label for="episodesPerSeason" class="form-label">Episódios / Temporada:</label>
                <input type="text"
                    id="episodesPerSeason"
                    name="episodesPerSeason"
                    class="form-control"
                    value="{{ $series->episodes()->get()->count() / $series->seasons()->get()->count(); }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <label for="cover" class="form-label">Capa:</label>
                <input type="file" id="cover" name="cover" class="form-control" accept="image/gif, image/jpeg, image/png">
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success mb-2">Editar Série</button>
        <button type="submit" class="btn btn-outline-danger mb-2" name="img-delete" value="true">Excluir Imagem</button>
    </form>
</x-layout>
