<?php

namespace App\Http\Services;

use App\Models\AbstracModel;
use App\Models\Cerveja;
use App\Models\Conceito;
use App\Models\Estabelecimento;
use App\Models\Pessoa;

class HelperService {
    private $model_conceito;
    private $model_cerveja;
    private $model_estabelecimento;
    private $model_pessoa;

    public function __construct(Conceito $model_conceito, Cerveja $model_cerveja, Estabelecimento $model_estabelecimento, Pessoa $model_pessoa) {
        $this->model_conceito = $model_conceito;
        $this->model_cerveja = $model_cerveja;
        $this->model_estabelecimento = $model_estabelecimento;
        $this->model_pessoa = $model_pessoa;
    }

    public function getConceitoByTipoAndId($tipo_conceito, $conceito_id): AbstracModel {

        switch ($tipo_conceito){
            case AbstracModel::CONCEITO_PESSOA:{
                return $this->model_pessoa->find($conceito_id)->first();
            }
            case AbstracModel::CONCEITO_CERVEJA:{
                return $this->model_cerveja->find($conceito_id)->first();
            }
            case AbstracModel::CONCEITO_ESTABELECIMENTO:{
                return $this->model_estabelecimento->find($conceito_id)->first();
            }
            default:{
                return $this->model_conceito->find($conceito_id);
            }
        }
    }
}
