<?php

namespace App\Http\Controllers;

use App\Models\{Episode, Season};
use Illuminate\Http\Request;

class EpisodesController
{
    public function index(Season $season)
    {
        return view('episodes.index', [
            'episodes' => $season->episodes()->paginate(10),
            'mensagemSucesso' => session('mensagem.sucesso'),
        ]);
    }

    public function update(Request $request, Season $season)
    {
        $watchedEpisodes = $request->episodes;
        $season->episodes->each(function (Episode $episode) use ($watchedEpisodes) {
            $episode->watched = in_array($episode->id, $watchedEpisodes);
        });


        $season->push();

        return to_route('episodes.index', $season->id)
            ->with('mensagem.sucesso', 'Episódios marcados como assistidos.');
    }
}
