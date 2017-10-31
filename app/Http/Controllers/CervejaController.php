<?php

namespace App\Http\Controllers;

use App\Http\Services\CervejaService;
use App\Http\Services\ConceitoService;
use Illuminate\Http\Request;

class CervejaController extends Controller
{
    private $cerveja_service;
    private $conceito_service;

    public function __construct(CervejaService $cerveja_service, ConceitoService $conceito_service) {
        $this->cerveja_service = $cerveja_service;
        $this->conceito_service = $conceito_service;
    }

    public function index(){
        $cervejas = $this->cerveja_service->getAll();

        return view('cerveja.cerveja_home', ['cervejas' => $cervejas]);
    }

    public function store(Request $request){
        $dados = $request->only('id', 'nome');

        $this->cerveja_service->storeCerveja($dados);

        return redirect()->back();
    }

    public function indexConceitos($cerveja_id){
        $cerveja = $this->cerveja_service->get($cerveja_id);
        $cerveja_conceitos = $cerveja->getConceitos();
        $conceitos = $this->conceito_service->getAll();

        return view('cerveja.cerveja_conceitos', ['cerveja_conceitos' => $cerveja_conceitos, 'conceitos' => $conceitos, 'cerveja' => $cerveja]);
    }

    public function storeConceito(Request $request){
        $cerveja_id = $request->only('cerveja_id');
        $conceito_id = $request->only('conceito_id')['conceito_id'];

        $this->cerveja_service->addConceito($cerveja_id, $conceito_id);
        return redirect()->back();

    }
}