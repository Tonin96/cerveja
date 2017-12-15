<?php

namespace App\Http\Services;

use App\Models\Contexto;

class ContextoService {
    private $model_contexto;

    public function __construct(Contexto $model_contexto) {
        $this->model_contexto = $model_contexto;
    }

    public function get($id): Contexto {
        if(is_array($id)){
            $id = $id['contexto_id'];
        }
        return $this->model_contexto->find($id);
    }

    public function getAll() {
        return $this->model_contexto->get();
    }

}
