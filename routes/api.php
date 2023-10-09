<?php

use App\Http\Controllers\Api\CoverController;
use App\Http\Controllers\Api\EpisodesController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\SeasonsController;
use App\Http\Controllers\Api\SeriesController;
use App\Http\Controllers\Api\WatchingEpisodesController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [LoginController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('/series', SeriesController::class);
    Route::get('/series/{series}/seasons', [SeasonsController::class, 'index']);
    Route::get('/series/{series}/episodes', [EpisodesController::class, 'index']);
    Route::patch('/episodes/{episode}', [WatchingEpisodesController::class, 'index']);

    Route::post('/set_cover', [CoverController::class, 'store']);
});
