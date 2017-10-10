<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\PessoaConceito;

class PessoaConceitoService {
    private $model_pessoa_conceito;
    private $model_conceito;

    public function __construct(PessoaConceito $model_pessoa_conceito, Conceito $model_conceito) {
        $this->model_pessoa_conceito = $model_pessoa_conceito;
        $this->model_conceito = $model_conceito;
    }

    public function get($id) {
        return $this->model_pessoa_conceito->find($id);
    }

    public function getAll() {
        return $this->model_pessoa_conceito->get();
    }

    public function storePessoaConceito($dados) {
        return $this->model_pessoa_conceito->insert($dados);
    }

    public function getConceitosByPessoa($pessoa_id){
        return $this->model_pessoa_conceito
            ->join('conceitos', 'conceitos.id', '=', 'pessoa_conceito.conceito_id')
            ->where('pessoa_conceito.pessoa_id', $pessoa_id)
            ->select('pessoa_conceito.id as id','pessoa_conceito.pessoa_id as pessoa_id', 'conceitos.id as conceito_id', 'conceitos.nome as conceito_nome')
            ->get();
    }

    public function delete($id) {

        $conceito = $this->model_pessoa_conceito->find($id);
        return $conceito->delete();
    }
}
