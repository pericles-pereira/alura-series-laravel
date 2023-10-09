<?php

namespace App\Providers;

use App\Repositories\{EloquentEpisodeRepository, EloquentSeriesRepository};
use App\Repositories\{EpisodesRepository, SeriesRepository};
use Illuminate\Support\ServiceProvider;

class RepositoriesProvider extends ServiceProvider
{
    public array $bindings = [
        SeriesRepository::class => EloquentSeriesRepository::class,
    ];
}
