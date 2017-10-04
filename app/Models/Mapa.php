<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mapa extends Model
{
    protected $table = 'mapas';

    protected $fillable = ['id','nome'];
}
