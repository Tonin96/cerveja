<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 10/10/17
 * Time: 20:31
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Estabelecimento extends Model{
    protected $table = 'estabeleciomentos';

    protected $fillable = ['id','nome', 'longitude', 'latitude', 'endereco'];
}