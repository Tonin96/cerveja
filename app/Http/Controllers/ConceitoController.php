<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\GoogleService;
use App\Models\Conceito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ConceitoController extends Controller {
    private $conceito_service;

    public function __construct(ConceitoService $conceito_service) {
        $this->conceito_service = $conceito_service;
    }

    public function index() {
        $conceitos = $this->conceito_service->getAll();

        return view('conceito.conceito_home', ['conceitos' => $conceitos]);
    }

    public function store(Request $request) {
        $dados = $request->only('id', 'nome', 'deletar');

        if (empty($dados['deletar'])) {
            unset($dados['deletar']);
            $this->conceito_service->storeConceito($dados);
        } else {
            $this->delete($request);
        }

        return redirect()->back();
    }

    public function delete(Request $request) {
        $dados = $request->only('id');

        $this->conceito_service->delete($dados['id']);
    }

}
