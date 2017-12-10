<?php

namespace App\Models;

class Cerveja extends AbstracModel {
    protected $table = 'cerveja';

    protected $fillable = ['id', 'nome', 'conceitos'];

    protected $tipo_conceito = AbstracModel::CONCEITO_CERVEJA;
}
