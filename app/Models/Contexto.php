<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Contexto extends Model {
    protected $table = 'contexto';

    protected $fillable = ['id', 'descricao', 'conceitos'];

    protected $tipo_conceito = AbstracModel::CONCEITO_MAPAS;
    private $arvore;

    public function modelo($conceito) {
        return json_decode(json_encode(['origem' => $conceito, 'destino' => []]));
    }

    public function getArvore() {

        return json_decode($this->conceitos);
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
        $this->arvore = $arvore;
    }


    public function addConceito($origem, $destino = null) {
        $this->arvore = json_decode($this->conceitos);

        if ($this->arvore[0]->origem == null) {
            $this->arvore[0]->origem = json_decode(json_encode($origem));
        } else {
            $this->adicionaRecursivamente($this->arvore, $origem, $destino);
        }

        $this->conceitos = json_encode($this->arvore);
        $this->save();
    }
}
