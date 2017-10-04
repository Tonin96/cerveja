<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conceito extends Model
{
    protected $table = 'conceitos';

    protected $fillable = ['id','nome'];
}
