<?php

namespace App\Http\Controllers;

use App\Http\Services\ConceitoService;
use App\Http\Services\HelperService;
use App\Http\Services\MapaService;
use Illuminate\Http\Request;

class MapaController extends Controller {
    private $conceito_service;
    private $mapa_service;
    private $helper_service;
    private $arrayArvore = array();
    private $count = 0;

    public function __construct(ConceitoService $conceito_service, MapaService $mapa_service, HelperService $helper_service) {
        $this->conceito_service = $conceito_service;
        $this->mapa_service = $mapa_service;
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

    public function indexConceitos($mapa_id) {
        $mapa = $this->mapa_service->get($mapa_id);
        $conceitos = $this->conceito_service->getAll();
        $arvore = $mapa->getArvore();
        $this->buscarArvoreRecursivamente($arvore);
        return view('mapa.mapa_conceitos', ['mapa_conceitos' => $this->arrayArvore, 'conceitos' => $conceitos, 'mapa' => $mapa]);
    }

    private function buscarArvoreRecursivamente($arvore) {
        if (!is_array($arvore)) {
            return;

        }

        array_map(function ($key) {

            if (count($key->destino) > 0) {
                foreach ($key->destino as $destino) {
                    array_push($this->arrayArvore, array('origem' => $key->origem->nome, 'destino' => $destino->origem->nome));
                }

                $this->count++;

                $this->buscarArvoreRecursivamente($key->destino);
            }
        }, ($arvore));

    }

    public function storeConceito(Request $request) {
        $mapa = $this->mapa_service->get($request->only('mapa_id'));
        $mapa->addConceito($this->conceito_service->get($request->only('conceito_origem_id')), $this->conceito_service->get($request->only('conceito_destino_id')));

        return redirect()->back();
    }


}
