<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pessoa extends Model {
    protected $table = 'pessoas';

    protected $fillable = ['id', 'nome', 'email', 'telefone', 'cpf', 'data_nascimento'];

}