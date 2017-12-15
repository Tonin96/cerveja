<?php

namespace App\Http\Controllers;

use App\Http\Services\CervejaService;
use App\Http\Services\ConceitoService;
use App\Http\Services\ContextoService;
use App\Http\Services\EstabelecimentoService;
use App\Http\Services\PessoaService;
use App\Models\AbstracModel;
use App\Models\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class PessoaController extends Controller {
    private $conceito_service;
    private $pessoa_service;
    private $cerveja_service;
    private $estabelecimento_service;
    private $contexto_service;

    private $conceitos_pessoa = array();
    private $arrayContextosPercentual = array();

    public function __construct(
        ConceitoService $conceito_service,
        PessoaService $pessoa_service,
        CervejaService $cerveja_service,
        EstabelecimentoService $estabelecimento_service,
        ContextoService $contexto_service
    ) {
        $this->conceito_service = $conceito_service;
        $this->pessoa_service = $pessoa_service;
        $this->cerveja_service = $cerveja_service;
        $this->estabelecimento_service = $estabelecimento_service;
        $this->contexto_service = $contexto_service;
    }

    public function index() {
        $pessoas = $this->pessoa_service->getAll();
        return view('pessoa.pessoa_home', ['pessoas' => $pessoas]);
    }

    public function meusDados() {
        $pessoa = $this->pessoa_service->getByUsuarioId(Auth::id());
        //dd($pessoa);
        return view('pessoa.meus_dados', ['pessoa' => $pessoa]);
    }

    public function salvarDados(Request $request) {
        $dados = $request->only('id', 'email', 'cpf', 'data_nascimento', 'telefone');

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

    public function beber(Request $request) {

        dd($request->session());
        $pessoa = $this->pessoa_service->get($request->session()->get('pessoa_id'));
        $cerveja = $this->cerveja_service->get($request->only('cerveja_id'));

        $estabelecimento = $this->estabelecimento_service->getByIdGoogle($request->only('estabelecimento_id')['estabelecimento_id']);
        $pessoa->beber($cerveja, $estabelecimento);

        return redirect()->back();
    }

    public function recomendar(Request $request) {

        $pessoa = $this->pessoa_service->get($request->session()->get('pessoa_id'));
        $contextos = $this->contexto_service->getAll();
        $conceitos_pessoa = $pessoa->getConceitos(AbstracModel::CONCEITO_CONCEITO)->toArray();

        var_dump(count($conceitos_pessoa));
        for ($i = 0; count($conceitos_pessoa) > $i; $i++) {
            array_push($this->conceitos_pessoa, $conceitos_pessoa[$i]->id);
        }


        $this->compararArvoreRecursivamente($contextos[0]->getArvore()->caracteristicas_pessoa);
        dd($contextos[0]->getArvore()->caracteristicas_pessoa);
    }

    private function compararArvoreRecursivamente($arvore) {
        if (!is_array($arvore)) {
            return;
        }

        array_map(function ($key) {
            if (in_array( $key->origem->id, $this->conceitos_pessoa)) {
                var_dump($key->origem->nome);

                if (count($key->destino) > 0) {

                    $this->compararArvoreRecursivamente($key->destino);
                }
            }


        }, ($arvore));

    }
}
