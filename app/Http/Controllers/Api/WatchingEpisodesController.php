<?php

namespace App\Http\Controllers\Api;

use App\Models\Episode;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;

class WatchingEpisodesController extends Controller
{
    public function index(Episode $episode, FormRequest $request)
    {
        $episode->watched = $request->watched;
        $episode->save();

        return $episode;
    }
}
