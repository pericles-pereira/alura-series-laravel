<x-layout title="Séries" :mensagem-sucesso="$mensagemSucesso">

    <ul class="list-group">
        @foreach ($series as $serie)
            <li class="list-group-item d-flex justify-content-between align-items-center mt-2">

                <div class="d-flex mt-2 mb-2">
                    <a @auth href="{{ route('seasons.index', $serie->id) }}" @endauth>

                        @if(!is_null($serie->cover))
                            <img src="{{ asset('storage/' . $serie->cover) }}" width="100px" class="img-thumbnail me-3" alt="">
                        @else
                            <img src="{{ asset('/storage/series_cover/default.png') }}" width="100px" class="img-thumbnail me-3" alt="">
                        @endif

                    </a>

                    <a @auth href="{{ route('seasons.index', $serie->id) }}" @endauth class="btn btn-light align-self-center" style="font-size: 18px;">
                        {{ $serie->nome }}
                    </a>
                </div>

                @auth
                    <span class="d-flex">
                        <a href="{{ route('series.edit', $serie->id) }}" class="btn btn-outline-info btn-sm"><i class="bi bi-pencil"></i></a>

                        <form action="{{ route('series.destroy', $serie->id) }}" method="post" class="ms-2">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm"><i class="bi bi-x-lg"></i></button>
                        </form>
                    </span>
                @endauth
            </li>
        @endforeach
    </ul>

        <div class="d-flex justify-content-center mt-4">
            {{ $series->links('pagination::bootstrap-4') }}
        </div>

    @auth
        <a href="{{ route('series.create') }}" class="btn btn-outline-dark mb-2 mt-2">Nova Série</a>
    @endauth
</x-layout>
