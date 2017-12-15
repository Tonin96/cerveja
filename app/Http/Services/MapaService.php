<?php

namespace App\Http\Services;

use App\Models\Mapa;

class MapaService {
    private $model_mapa;
    private $model_mapa_conceito;

    public function __construct(Mapa $model_mapa) {
        $this->model_mapa = $model_mapa;
    }

    public function get($id): Mapa {
        if(is_array($id)){
            $id = $id['mapa_id'];
        }
        return $this->model_mapa->find($id);
    }

    public function getAll() {
        return $this->model_mapa->get();
    }

    public function storeMapa($dados) {

        if (!empty($dados['id'])) {
            $conceito = $this->model_mapa->find($dados['id']);
            return $conceito->update(['nome' => $dados['nome']]);
        } else {
            return $this->model_mapa->insert(['nome' => $dados['nome']]);
        }
    }
}
