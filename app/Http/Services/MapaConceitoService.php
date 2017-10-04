<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\MapaConceito;
use Illuminate\Http\Request;

class MapaConceitoService {
    private $model_mapa_conceito;
    private $model_conceito;

    public function __construct(MapaConceito $model_mapa_conceito, Conceito $model_conceito) {
        $this->model_mapa_conceito = $model_mapa_conceito;
        $this->model_conceito = $model_conceito;
    }

    public function get($id) {
        return $this->model_mapa_conceito->find($id);
    }

    public function getAll() {
        return $this->model_mapa_conceito->get();
    }

    public function storeMapaConceito($dados) {

        $this->model_mapa_conceito->insert($dados);

        return true;
    }

    public function delete($id) {
        $conceito = $this->model_mapa_conceito->find($id);


        return $conceito->delete();
    }

    public function getConceitosSemPai(){
        return $this->model_conceito
            ->leftJoin('relacao_mapa_conceito as relacao', 'relacao.conceito_destino_id', '=', 'conceitos.id')
            ->whereNull('relacao.id')
            ->select('conceitos.id', 'conceitos.nome')
            ->distinct()
            ->get();
    }


}
