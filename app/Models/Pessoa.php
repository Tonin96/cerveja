<?php

namespace App\Models;

class Pessoa extends AbstracModel {
    protected $table = 'pessoas';

    protected $fillable = ['id', 'nome', 'email', 'telefone', 'cpf', 'data_nascimento', 'usuario_id'];

    protected $tipo_conceito = AbstracModel::CONCEITO_PESSOA;
}