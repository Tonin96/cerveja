<?php
namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model{
    protected $table = 'estabelecimentos';

    protected $fillable = ['id','nome', 'id_google', 'conceitos'];

    protected $tipo_conceito = AbstracModel::CONCEITO_BEBEU;
}