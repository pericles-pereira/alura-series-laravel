@component('mail::message')

# Série {{ $nome }} criada!

A série {{ $nome }} com {{ $seasonsQty }} temporadas e {{ $episodesPerSeason }} episódios por temporada foi criada.

Acesse aqui:

@component('mail::button', ['url' => route('seasons.index', $id)])
    Ver série
@endcomponent

@endcomponent