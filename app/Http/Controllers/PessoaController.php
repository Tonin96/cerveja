<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Services\CervejaService;
use App\Http\Services\ConceitoService;
use App\Http\Services\PessoaService;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller {
    private $conceito_service;
    private $pessoa_service;
    private $cerveja_service;

    public function __construct(ConceitoService $conceito_service, PessoaService $pessoa_service, CervejaService $cerveja_service) {
        $this->conceito_service = $conceito_service;
        $this->pessoa_service = $pessoa_service;
        $this->cerveja_service = $cerveja_service;
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

    public function indexConceitos($pessoa_id) {

        $pessoa = $this->pessoa_service->get($pessoa_id);
        $pessoa->addConceito($this->cerveja_service->get(1));
        $conceitos_pessoa = $pessoa->getConceitos(Pessoa::CONCEITO_CONCEITO);
        $conceitos = $this->conceito_service->getAll();


        return view('pessoa.pessoa_conceito', ['pessoa' => $pessoa, 'conceitos_pessoa' => $conceitos_pessoa, 'conceitos' => $conceitos]);
    }

    public function storeConceito(Request $request) {
        $pessoa = $this->pessoa_service->get($request->only('pessoa_id'));
        $conceito = $this->conceito_service->get($request->only('conceito_id'));

        $pessoa->addConceito($conceito);

        return redirect()->back();
    }
}
