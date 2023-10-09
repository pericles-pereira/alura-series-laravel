<x-layout title="Episódios" :mensagem-sucesso="$mensagemSucesso">
    <form method="POST">
        @csrf
        <ul class="list-group mt-3">
            @foreach ($episodes as $episode)
                <li class="list-group-item d-flex justify-content-between align-items-center" style="font-size: 17px;">
                    Episósio {{ $episode->number }}

                    <input type="checkbox" name="episodes[]" value="{{ $episode->id }}" @checked($episode->watched)>
            @endforeach
        </ul>

        <div class="d-flex justify-content-center mt-4">
            {{ $episodes->links('pagination::bootstrap-4') }}
        </div>

        <button class="btn btn-outline-success mt-2 mb-2">Salvar</button>
    </form>
</x-layout>
