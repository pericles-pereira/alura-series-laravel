<x-layout title="Temporadas de {!! $series->nome !!}">

    <div class="d-flex justify-content-center mt-3">
        @if(!is_null($series->cover))
            <img src="{{ asset('storage/' . $series->cover) }}" alt="Capa da série" class="img-fluid" style="max-height: 300px;">
        @else
            <img src="{{ asset('/storage/series_cover/default.png') }}" alt="Capa da série" class="img-fluid" style="max-height: 300px;">
        @endif
    </div>

    <ul class="list-group mt-5">
        @foreach ($seasons as $season)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <a href="{{ route('episodes.index', $season->id) }}" class="btn btn-light" style="font-size: 18px;">
                    Temporada {{ $season->number }}
                </a>

                <span class="badge bg-secondary">
                    {{ $season->numberOfWatchedEpisodes() }} / {{ $season->episodes->count() }}
                </span>
            </li>
        @endforeach

        <div class="d-flex justify-content-center mt-4">
            {{ $seasons->links('pagination::bootstrap-4') }}
        </div>

    </ul>
</x-layout>
