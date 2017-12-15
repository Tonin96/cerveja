<?php

namespace App\Models;

use Carbon\Carbon;

class Pessoa extends AbstracModel {
    protected $table = 'pessoas';

    protected $fillable = ['id', 'nome', 'email', 'telefone', 'cpf', 'data_nascimento', 'usuario_id'];

    protected $tipo_conceito = AbstracModel::CONCEITO_PESSOA;

    public function beber(Cerveja $cerveja, Estabelecimento $estabelecimento) {
        $tipo_conceito = AbstracModel::CONCEITO_BEBEU;

        if ($this->validaConceitos($tipo_conceito)) {
            $conceitos = collect(json_decode($this->conceitos)->$tipo_conceito);
        } else {
            $conceitos = collect();
        }

        ;
        $conceito = collect(['cerveja' => $cerveja->only('id'), 'estabelecimento' => $estabelecimento->only('id_google'), 'data'=>Carbon::now()->toDateTimeString()]);

        $conceitos->push($conceito);

        $collection_conceitos = collect(json_decode($this->conceitos));
        $collection_conceitos[$tipo_conceito] = $conceitos;

        $this->conceitos = json_encode($collection_conceitos);

        $this->save();

        return true;
    }
}