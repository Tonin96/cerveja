<?php

namespace App\Http\Services;

use App\Models\Conceito;
use App\Models\Mapa;
use App\Models\MapaConceito;
use Illuminate\Http\Request;

class MapaService {
    private $model_mapa;
    private $model_mapa_conceito;

    public function __construct(Mapa $model_mapa, MapaConceito $model_mapa_conceito) {
        $this->model_mapa = $model_mapa;
        $this->model_mapa_conceito = $model_mapa_conceito;
    }

    public function get($id): Mapa {
        return $this->model_mapa->find($id);
    }

    public function getAll() {
        return $this->model_mapa->get();
    }

    public function storeMapa($dados) {

        if (!empty($dados['id'])) {
            $conceito = $this->model_mapa->find($dados['id']);
            return $conceito->update(['nome' => $dados['nome']]);
        } else {
            return $this->model_mapa->insert(['nome' => $dados['nome']]);
        }
    }

    public function getConceitosByMapa($mapa_id) {
        return $this->model_mapa_conceito
            ->join('conceitos as origem', 'origem.id', '=', 'conceito_origem_id')
            ->join('conceitos as destino', 'destino.id', '=', 'conceito_destino_id')
            ->where('mapa_id', '=', $mapa_id)
            ->select('origem.id as origem_id', 'origem.nome as origem_nome', 'destino.id as destino_id', 'destino.nome as destino_nome')
            ->get();
    }

    public function getOrigensByMapa($mapa_id) {
        return $this->model_mapa_conceito
            ->join('conceito as origem', 'origem.id', '=', 'conceito_origem_id')
            ->where('mapa_id', '=', $mapa_id)
            ->select('origem.id as origem_id', 'origem.nome as origem_nome')
            ->distinct()
            ->get();
    }

    public function getDestinosByOrigem($conceito_origem_id) {
        return $this->model_mapa_conceito
            ->join('conceito as destino', 'destino.id', '=', 'conceito_destino_id')
            ->where('conceito_destino_id', '=', $conceito_origem_id)
            ->select('destino.id as destino_id', 'destino.nome as destino_nome')
            ->distinct()
            ->get();
    }


}
