<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conceito extends AbstracModel {
    protected $table = 'conceitos';

    protected $fillable = ['id', 'nome'];
    protected $hidden = ['created_at', 'updated_at'];

    protected $tipo_conceito = AbstracModel::CONCEITO_CONCEITO;
}
