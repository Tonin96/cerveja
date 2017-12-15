<?php
/**
 * Created by PhpStorm.
 * User: bruno
 * Date: 31/10/17
 * Time: 20:04
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use PHPUnit\Exception;

class AbstracModel extends Model {

    protected $tipo_conceito;

    const CONCEITO_CERVEJA = 'cervejas';
    const CONCEITO_CONCEITO = 'conceitos';
    const CONCEITO_PESSOA = 'pessoas';
    const CONCEITO_ESTABELECIMENTO = 'estabelecimentos';
    const CONCEITO_MAPAS = 'mapas';
    const CONCEITO_BEBEU = 'bebeu';
    const CARACTERISTICAS_PESSOA = 'caracteristicas_pessoa';

    public function getConceitos($tipo_conceito): Collection {

        if ($this->validaConceitos($tipo_conceito)) {
            $conceitos = collect(json_decode($this->conceitos)->$tipo_conceito);

            return $conceitos;
        }
        return collect();
    }

    public function addConceito(Model $conceito, $tipo_conceito = null) {
        if(empty($tipo_conceito)){
            $tipo_conceito = $conceito->tipo_conceito;
        }
        if ($this->validaConceitos($tipo_conceito)) {
            $conceitos = collect(json_decode($this->conceitos)->$tipo_conceito);
        } else {
            $conceitos = collect();
        }
        $conceitos->push($conceito);

        $collection_conceitos = collect(json_decode($this->conceitos));
        $collection_conceitos[$tipo_conceito] = $conceitos;

        $this->conceitos = json_encode($collection_conceitos);
        $this->save();
        return true;
    }

    public function dropConceito(Model $conceito) {
        $tipo_conceito = $conceito->tipo_conceito;
        $conceitos = collect(json_decode($this->conceitos)->$tipo_conceito);

        $conceitos->forget($conceito->id);
        $collection_conceitos = collect(json_decode($this->conceitos));
        $collection_conceitos[$tipo_conceito] = $conceitos;

        $this->conceitos = json_encode($collection_conceitos);
        $this->save();
        return true;
    }

    public function validaConceitos($tipo_conceito) {
        $conceitos = json_decode($this->conceitos);

        if (isset($conceitos->$tipo_conceito)) {
            return true;
        }
        return false;
    }
}