<?php

namespace App\Http\Controllers;

use App\Http\Services\MapaConceitoService;
use Illuminate\Http\Request;

class MapaConceitoController extends Controller {
    private $mapa_conceito_service;


    public function __construct(MapaConceitoService $mapa_conceito_service) {
        $this->mapa_conceito_service = $mapa_conceito_service;
    }

    public function store(Request $request) {
        $dados = $request->only('mapa_id', 'conceito_origem_id', 'conceito_destino_id');

        $this->mapa_conceito_service->storeMapaConceito($dados);

        return redirect()->back();
    }

    public function drop(Request $request){
        $id = $request->only('mapa_id');

        $this->mapa_conceito_service->delete($id);

        return redirect()->back();
    }

}