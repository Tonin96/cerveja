<?php

namespace App\Http\Controllers;

use App\Http\Services\ConceitoService;
use App\Http\Services\PessoaConceitoService;
use App\Http\Services\PessoaService;
use Illuminate\Http\Request;

class PessoaConceitoController extends Controller {

    private $pessoa_conceito_sevice;
    private $pessoa_service;
    private $conceito_service;

    public function __construct(PessoaConceitoService $pessoa_conceito_sevice, PessoaService $pessoa_service, ConceitoService $conceito_service) {
        $this->pessoa_conceito_sevice = $pessoa_conceito_sevice;
        $this->pessoa_service = $pessoa_service;
        $this->conceito_service = $conceito_service;
    }

    public function index($pessoa_id) {

        $pessoa = $this->pessoa_service->get($pessoa_id);
        $conceitos_pessoa = $this->pessoa_conceito_sevice->getConceitosByPessoa($pessoa_id);
        $conceitos = $this->conceito_service->getAll();
        return view('pessoa.pessoa_conceito', ['pessoa' => $pessoa, 'conceitos_pessoa' => $conceitos_pessoa, 'conceitos' => $conceitos]);
    }

    public function store(Request $request) {
        $dados = $request->only('pessoa_id', 'conceito_id');

        $this->pessoa_conceito_sevice->storePessoaConceito($dados);

        return redirect()->back();
    }

    public function drop($id) {

        $this->pessoa_conceito_sevice->delete($id);

        return redirect()->back();
    }
}
