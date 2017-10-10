<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\Pessoa;
use App\User;

class PessoaService {
    private $model_conceito;
    private $model_pessoa;
    private $model_usuario;

    public function __construct(Conceito $model_conceito, Pessoa $model_pessoa, User $model_usuario) {
        $this->model_conceito = $model_conceito;
        $this->model_pessoa = $model_pessoa;
        $this->model_usuario = $model_usuario;
    }

    public function get($id) {
        return $this->model_pessoa->find($id);
    }

    public function getAll() {
        return $this->model_pessoa->get();
    }

    public function getByUsuarioId($usuario_id) {
        return $this->model_pessoa
            ->where('usuario_id', $usuario_id)
            ->get()
            ->first();
    }

    public function update($dados) {
        $pessoa = $this->model_pessoa->find($dados['id']);


        $chars = array(".", "/", "-", "(", ")", ' ');
        $dados['cpf'] = str_replace($chars, "", $dados['cpf']);
        $dados['telefone'] = str_replace($chars, "", $dados['telefone']);
        $pessoa->email = $dados['email'];
        $pessoa->cpf = $dados['cpf'];
        $pessoa->telefone = $dados['telefone'];
        $pessoa->data_nascimento = $dados['data_nascimento'];

        return $pessoa->save();

    }
}
