<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\MapaConceitoService;
use App\Http\Services\MapaService;
use App\Models\Conceito;
use Illuminate\Http\Request;

class MapaController extends Controller {
    private $conceito_service;
    private $mapa_service;
    private $mapa_conceito_service;

    public function __construct(ConceitoService $conceito_service, MapaService $mapa_service, MapaConceitoService $mapa_conceito_service) {
        $this->conceito_service = $conceito_service;
        $this->mapa_service = $mapa_service;
        $this->mapa_conceito_service = $mapa_conceito_service;
    }

    public function index() {
        $mapas = $this->mapa_service->getAll();

        return view('mapa.mapa_home', ['mapas' => $mapas]);
    }

    public function store(Request $request) {
        $dados = $request->only('id', 'nome');

        if (!empty($dados['nome'])) {
            $this->mapa_service->storeMapa($dados);
        }

        return redirect()->back();
    }

    public function getConceitosByMapa($mapa_id) {
        $conceitos_mapa = $this->mapa_service->getConceitosByMapa($mapa_id);
        $conceitos = $this->conceito_service->getAll();
        $conceito_livre = $this->mapa_conceito_service->getConceitosSemPai();

        return view('mapa.mapa_conceitos', ['conceitos_mapa' => $conceitos_mapa, 'conceitos' => $conceitos, 'conceitos_livres' => $conceito_livre,'mapa_id' => $mapa_id]);
    }


}
