<?php

namespace App\Http\Controllers;

use App\Models\Series;

class SeasonsController extends Controller
{
    public function index(Series $series)
    {
        $seasons = $series->seasons()->with('episodes')->paginate(10);

        return view('seasons.index', compact('seasons', 'series'));
    }
}
