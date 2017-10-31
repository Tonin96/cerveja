<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cerveja extends Model {
    protected $table = 'cerveja';

    protected $fillable = ['id', 'nome', 'conceitos'];


    public function getConceitos() {
        if (!empty($this->conceitos)) {
            $conceitos = json_decode($this->conceitos)->conceitos;
            return  DB::table('conceitos')->whereIn('id', $conceitos)->get();
        }
        return collect();
    }
}
