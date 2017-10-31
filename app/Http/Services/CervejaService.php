<?php

namespace App\Http\Services;

use App\Models\Cerveja;
use App\Models\Conceito;
use Illuminate\Support\Facades\DB;

class CervejaService {
    private $model_cerveja;
    private $model_conceito;

    public function __construct(Cerveja $model_cerveja, Conceito $model_conceito) {
        $this->model_cerveja = $model_cerveja;
        $this->model_conceito = $model_conceito;
    }

    public function get($id) {
        return $this->model_cerveja->find($id);
    }

    public function getAll() {
        return $this->model_cerveja->get();
    }

    public function delete($id) {
        $conceito = $this->model_cerveja->find($id);

        return $conceito->delete();
    }

    public function storeCerveja($dados) {
        if ($dados['id']) {
            $conceito = $this->model_cerveja->find($dados['id']);
            $conceito->update(['nome' => $dados['nome']]);
        } else {
            $this->model_cerveja->insert($dados);
        }

        return true;
    }

    public function addConceito($cerveja_id, $conceito_id) {
        $cerveja = $this->get($cerveja_id)[0];
        $conceitos_cerveja = $cerveja->getConceitos();
        $conceitos_ids = collect();

        foreach ($conceitos_cerveja as $key) {
            $conceitos_ids->push($key->id);
        }
        $conceitos_ids->push(intval($conceito_id));
        $conceitos = json_encode(array('conceitos' => $conceitos_ids));

        return $cerveja->update(['conceitos->conceitos' => $conceitos]);
    }

}