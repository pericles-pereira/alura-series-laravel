<?php

namespace App\Repositories;

use App\Jobs\SeriesDestroy;
use App\Models\{Episode, Season, Series};
use Illuminate\Support\Facades\DB;

class EloquentSeriesRepository implements SeriesRepository
{
    public function add(array $serieInfo): Series
    {
        return DB::transaction(function () use ($serieInfo) {
            $serie = Series::create($serieInfo);
            $seasons = [];

            for ($i = 1; $i <= $serieInfo['seasonsQty']; $i++) {
                $seasons[] = [
                    'series_id' => $serie->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($serie->seasons as $season) {
                for ($j = 1; $j <= $serieInfo['episodesPerSeason']; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }
            }
            Episode::insert($episodes);

            return $serie;
        });
    }

    public function update(Series $series, array $serieInfo): Series
    {
        return DB::transaction(function () use ($series, $serieInfo) {

            $series->fill(['nome' => $serieInfo['nome']]);

            if (!is_null($serieInfo['cover'])) {
                SeriesDestroy::dispatch($series->cover);
                $series->fill(['cover' => $serieInfo['cover']]);
            }

            $series->save();

            $seasonsQty = $series->seasons()->get()->count();
            $episodesPerSeason = $series->episodes()->get()->count() / $seasonsQty;
            if (intval($serieInfo['seasonsQty']) === $seasonsQty && intval($serieInfo['episodesPerSeason']) === $episodesPerSeason) {
                return $series;
            }

            $series->seasons()->delete();

            $seasons = [];
            for ($i = 1; $i <= $serieInfo['seasonsQty']; $i++) {
                $seasons[] = [
                    'series_id' => $series->id,
                    'number' => $i,
                ];
            }
            Season::insert($seasons);

            $episodes = [];
            foreach ($series->seasons as $season) {
                for ($j = 1; $j <= $serieInfo['episodesPerSeason']; $j++) {
                    $episodes[] = [
                        'season_id' => $season->id,
                        'number' => $j,
                    ];
                }
            }
            Episode::insert($episodes);

            return $series;
        });
    }

    public function imgDelete(Series $series): bool
    {
        SeriesDestroy::dispatch($series->cover);
        $series->fill(['cover' => null]);

        return $series->save();
    }
}
