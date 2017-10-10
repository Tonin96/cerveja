<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PessoaConceito extends Model {
    protected $table = 'pessoa_conceito';

    protected $fillable = ['id', 'pessoa_id', 'conceito_id'];
}
