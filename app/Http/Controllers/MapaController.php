<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\HelperService;
use App\Http\Services\MapaConceitoService;
use App\Http\Services\MapaService;
use App\Models\Conceito;
use App\Models\Mapa;
use Illuminate\Http\Request;

class MapaController extends Controller {
    private $conceito_service;
    private $mapa_service;
    private $mapa_conceito_service;
    private $helper_service;

    public function __construct(ConceitoService $conceito_service, MapaService $mapa_service, MapaConceitoService $mapa_conceito_service, HelperService $helper_service) {
        $this->conceito_service = $conceito_service;
        $this->mapa_service = $mapa_service;
        $this->mapa_conceito_service = $mapa_conceito_service;
        $this->helper_service = $helper_service;
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

    public function indexConceitos($mapa_id) {


        $mapa = $this->mapa_service->get($mapa_id);
        $mapa->getArvore();
        $mapa_conceitos = $mapa->getConceitos(Mapa::CONCEITO_CONCEITO);
        $conceitos = $this->conceito_service->getAll();

        return view('mapa.mapa_conceitos', ['mapa_conceitos' => $mapa_conceitos, 'conceitos' => $conceitos,  'mapa_id', 'mapa' => $mapa]);
    }

    public function storeConceito(Request $request) {
        $cerveja = $this->mapa_service->get($request->only('mapa_id'));
        $tipo_conceito = $request->only('tipo_conceito');
        //$conceito = $this->helper_service->getConceitoByTipoAndId($tipo_conceito, $request->only('conceito_id')['conceito_id']);
        $cerveja->addConceito($cerveja);

        return redirect()->back();
    }


}
