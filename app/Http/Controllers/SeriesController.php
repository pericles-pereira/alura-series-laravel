<?php

namespace App\Http\Controllers;

use App\Events\SeriesCreated;
use App\Http\Requests\SeriesRequest;
use App\Jobs\SeriesDestroy;
use App\Models\Series;
use App\Repositories\SeriesRepository;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $repository)
    {
        $this->middleware('auth')->except('index');
    }

    public function index()
    {
        $series = Series::with(['seasons'])->paginate(5);
        $mensagemSucesso = session('mensagem.sucesso');

        return view('series.index', compact('series', 'mensagemSucesso'));
    }

    public function create()
    {
        return view('series.create');
    }

    public function store(SeriesRequest $request)
    {
        $serieInfo = $request->except(['_token', 'cover']);

        $coverPath = $request->hasFile('cover') ? $request->file('cover')->store('series_cover', 'public') : null;
        $serieInfoWithCover = $serieInfo;
        $serieInfoWithCover['cover'] = $coverPath;

        $serie = $this->repository->add($serieInfoWithCover);

        $seriesCreated = new SeriesCreated($serie->id, ...$serieInfo);
        event($seriesCreated);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada com sucesso");
    }

    public function edit(Series $series)
    {
        return view('series.edit', compact('series'));
    }

    public function update(Series $series, SeriesRequest $request)
    {
        if(boolval($request->only('img-delete')) === true) {
            $this->repository->imgDelete($series);

            return to_route('series.index')
                ->with('mensagem.sucesso', "Capa da série '{$series->nome}' removida com sucesso");
        }

        $serieInfo = $request->except(['_token', '_method', 'cover']);
        $coverPath = $request->hasFile('cover') ? $request->file('cover')->store('series_cover', 'public') : null;

        $serieInfo['cover'] = $coverPath;
        $updatedSerie = $this->repository->update($series, $serieInfo);

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$updatedSerie->nome}' atualizada com sucesso");
    }

    public function destroy(Series $series)
    {
        if (!is_null($series->cover)) {
            SeriesDestroy::dispatch($series->cover);
        }
        $series->delete();

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida com sucesso");
    }
}
