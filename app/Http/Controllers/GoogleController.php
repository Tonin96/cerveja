<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\GoogleService;
use App\Models\Conceito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class GoogleController extends Controller {
    private $google_service;

    public function __construct(GoogleService $google_service) {
        $this->google_service = $google_service;
    }

    public function getEstalecimentosByPosition(Request $request) {
        $dados = $request->only('latitude', 'longitude', 'radius');

        $latitude = $dados['latitude'];
        $longitude = $dados['longitude'];
        $radius = $dados['radius'];

        return $this->google_service->getEstalecimentosByPosition($latitude, $longitude, $radius);
    }
}
