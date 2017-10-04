<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\PessoaService;

class PessoaController extends Controller
{
    private $conceito_service;
    private $pessoa_service;

    public function __construct(ConceitoService $conceito_service, PessoaService $pessoaService)
    {
        $this->conceito_service = $conceito_service;
        $this->pessoa_service = $pessoaService;
    }

    public function index()
    {
        $pessoas = $this->pessoa_service->getAll();
        return view('pessoa.pessoa_home', ['pessoas' => $pessoas]);
    }


}
