<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CoverRequest;

class CoverController extends Controller
{
    public function store(CoverRequest $request)
    {
        $path = $request->file('cover')->store('series_cover', 'public');
        return response()->json([
            'Mensagem' => 'Imagem recebida! Informe seu caminho na criação da sua série!',
            'Caminho da imagem' => $path,
        ], 201);
    }
}
