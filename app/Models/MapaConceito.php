<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MapaConceito extends Model {
    protected $table = 'relacao_mapa_conceito';

    protected $fillable = ['id', 'mapa_id', 'conceito_origem_id', 'conceito_destino_id'];

    public function subcategorias() {
        return $this->hasMany(MapaConceito::class, 'conceito_origem_id', 'conceito_destino_id');
    }

    public function allSubcategorias() {
        return $this->subcategorias()->with('allSubcategorias');
    }
}
