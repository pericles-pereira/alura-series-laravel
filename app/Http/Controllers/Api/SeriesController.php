<?php

namespace App\Http\Controllers\Api;

use App\Models\Series;
use App\Http\Controllers\Controller;
use App\Http\Requests\SeriesRequest;
use App\Repositories\SeriesRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Http\FormRequest;

class SeriesController extends Controller
{
    public function __construct(private SeriesRepository $seriesRepository)
    {
    }

    public function index(FormRequest $request)
    {
        $query = Series::query();
        if ($request->has('nome')) {
            $query->where('nome', $request->nome);
        }

        return $query->paginate(5);
    }

    public function store(SeriesRequest $request)
    {
        $serieInfo = $request->except(['_token', 'cover']);
        return response()
            ->json($this->seriesRepository->add($serieInfo), 201);
    }

    public function show(int $series)
    {
        $seriesModel = Series::with('seasons.episodes')->find($series);
        if (is_null($seriesModel)) {
            return response()->json(['message' => 'Series not found'], 404);
        }

        return $seriesModel;
    }

    public function update(Series $series, SeriesRequest $request)
    {
        $series->fill($request->all());
        $series->save();

        return $series;
    }

    public function destroy(int $series, Authenticatable $user)
    {
        if ($user->tokenCan('is_admin')){
            Series::destroy($series);

            return response()->noContent();
        }

        return response()->json('Unauthorized', 401);
    }
}
