<?php

namespace App\Http\Services;

use App\Models\Conceito;
use Illuminate\Http\Request;

class ConceitoService {
    private $model_conceito;

    public function __construct(Conceito $model_conceito) {
        $this->model_conceito = $model_conceito;
    }

    public function get($id) {
        return $this->model_conceito->find($id);
    }

    public function getAll() {
        return $this->model_conceito->get();
    }

    public function storeConceito($dados) {

        if ($dados['id']) {
            $conceito = $this->model_conceito->find($dados['id']);
            $conceito->update(['nome' => $dados['nome']]);
        } else {
            $this->model_conceito->insert($dados);
        }


        return true;
    }

    public function delete($id) {
        $conceito = $this->model_conceito->find($id);


        return $conceito->delete();
    }


}
