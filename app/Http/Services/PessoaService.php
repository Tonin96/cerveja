<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\Pessoa;

class PessoaService
{
    private $model_conceito;
    private $model_pessoa;

    public function __construct(Conceito $model_conceito, Pessoa $model_pessoa)
    {
        $this->model_conceito = $model_conceito;
        $this->model_pessoa = $model_pessoa;
    }

    public function get($id)
    {
        return $this->model_pessoa->find($id);
    }

    public function getAll()
    {
        return $this->model_pessoa->get();
    }
}
