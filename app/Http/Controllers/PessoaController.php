<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\ConceitoService;
use App\Http\Services\PessoaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller {
    private $conceito_service;
    private $pessoa_service;

    public function __construct(ConceitoService $conceito_service, PessoaService $pessoa_service) {
        $this->conceito_service = $conceito_service;
        $this->pessoa_service = $pessoa_service;
    }

    public function index() {
        $pessoas = $this->pessoa_service->getAll();
        return view('pessoa.pessoa_home', ['pessoas' => $pessoas]);
    }

    public function meusDados(){
        $pessoa = $this->pessoa_service->getByUsuarioId(Auth::id());
        //dd($pessoa);
        return view('pessoa.meus_dados', ['pessoa' => $pessoa]);
    }

    public function salvarDados(Request $request){
        $dados = $request->only('id', 'email', 'cpf','data_nascimento', 'telefone');

        $this->pessoa_service->update($dados);

        return redirect()->back();
    }


}
