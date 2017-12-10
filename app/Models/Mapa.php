<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PHPUnit\Exception;

class Mapa extends Model {
    protected $table = 'mapas';

    protected $fillable = ['id', 'nome', 'conceitos'];

    protected $tipo_conceito = AbstracModel::CONCEITO_MAPAS;
    private $arvore;

    public function modelo($conceito) {
        return json_decode(json_encode(['origem' => $conceito, 'destino' => []]));
    }

    public function getArvore() {

        $this->arvore = json_decode($this->conceitos);


        $conceito1 = Conceito::find(1);
        $conceito2 = Conceito::find(2);
        $conceito3 = Conceito::find(3);
        $conceito4 = Conceito::find(4);


        $this->addConceito($conceito1);

        $this->addConceito($conceito1, $conceito2);

        $this->addConceito($conceito2, $conceito3);
        $this->addConceito($conceito2, $conceito4);
        dd($this->arvore);
    }

    private function adicionaRecursivamente($arvore, $origem, $destino) {
        if(!is_array($arvore)){
            $arvore = array($arvore);
        }

        array_map(function ($key) use ($origem, $destino) {
            if ($key->origem->id == $origem->id) {
                     array_push($key->destino, $this->modelo($destino));
            } else {
                $this->adicionaRecursivamente($key->destino, $origem, $destino);
            }

        }, ($arvore));
        $this->arvore = $arvore[0];
    }


    private function addConceito($origem, $destino = null) {

        if ($this->arvore->origem == null) {
            $this->arvore->origem = json_decode(json_encode($origem));
            return;
        } else {
            $this->adicionaRecursivamente($this->arvore, $origem, $destino);
        }
    }
}
