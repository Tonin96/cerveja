<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\Estabelecimento;


class EstabelecimentoService {
    private $model_estabelecimento;
    private $model_conceito;
    private $google_service;

    public function __construct(Estabelecimento $model_estabelecimento, Conceito $model_conceito, GoogleService $google_service) {
        $this->model_estabelecimento = $model_estabelecimento;
        $this->model_conceito = $model_conceito;
        $this->google_service = $google_service;
    }

    public function get($id): Estabelecimento {
        return $this->model_estabelecimento->find($id)->first();
    }

    public function getAll() {
        return $this->model_estabelecimento->get();
    }

    public function getByIdGoogle(String $id_google): Estabelecimento{
        $estabelecimento = $this->model_estabelecimento->where('id_google' , '=', $id_google)->get()->first();
        if(!empty($estabelecimento)){
            return $estabelecimento;
        }else{
            $estabelecimento = $this->google_service->getEstabelecimentoById($id_google);

            $this->model_estabelecimento->id_google = $estabelecimento['place_id'];
            $this->model_estabelecimento->nome = $estabelecimento['name'];
            $this->model_estabelecimento->save();
            return $this->model_estabelecimento;
        }

    }
}