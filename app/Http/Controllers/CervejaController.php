<?php

namespace App\Http\Controllers;

use App\Http\Services\CervejaService;
use App\Http\Services\ConceitoService;
use App\Http\Services\HelperService;
use App\Models\Cerveja;
use Illuminate\Http\Request;

class CervejaController extends Controller {
    private $cerveja_service;
    private $conceito_service;
    private $helper_service;

    public function __construct(CervejaService $cerveja_service, ConceitoService $conceito_service, HelperService $helper_service) {
        $this->cerveja_service = $cerveja_service;
        $this->conceito_service = $conceito_service;
        $this->helper_service = $helper_service;
    }

    public function index() {
        $cervejas = $this->cerveja_service->getAll();

        return view('cerveja.cerveja_home', ['cervejas' => $cervejas]);
    }

    public function store(Request $request) {
        $dados = $request->only('id', 'nome');
        $this->cerveja_service->storeCerveja($dados);

        return redirect()->back();
    }

    public function indexConceitos($cerveja_id) {
        $cerveja = $this->cerveja_service->get($cerveja_id);
        $cerveja_conceitos = $cerveja->getConceitos(Cerveja::CONCEITO_CONCEITO);
        $conceitos = $this->conceito_service->getAll();

        return view('cerveja.cerveja_conceitos', ['cerveja_conceitos' => $cerveja_conceitos, 'conceitos' => $conceitos, 'cerveja' => $cerveja]);
    }

    public function storeConceito(Request $request) {
        $cerveja = $this->cerveja_service->get($request->only('cerveja_id'));
        $tipo_conceito = $request->only('tipo_conceito');
        $conceito = $this->helper_service->getConceitoByTipoAndId($tipo_conceito, $request->only('conceito_id')['conceito_id']);
        $cerveja->addConceito($conceito);

        return redirect()->back();
    }
}