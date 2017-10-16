<?php

namespace App\Http\Services;

use App\Models\Conceito;
use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;

class GoogleService {

    private $types = array('bar', 'cafe', 'night_club', 'casino', 'restaurant');

    public function __construct() {

    }

    public function getEstalecimentosByPosition(String $latitude, String $longitude, String $radius) {
        $google = new GoogleMaps();
        $location = array($latitude, $longitude);

        $location = implode(",", $location);
        $estabelecimentos = array();

        foreach ($this->types as $type) {
            $response = $google->load('nearbysearch')
                ->setParam(['location' => $location])
                ->setParam(['radius' => $radius])
                ->setParam(['type' => $type])
                ->setParam(['opennow' => 'opennow'])
                ->get(true);
            $estabelecimentos = array_merge($estabelecimentos, $response['results']);
        }

        return response()->json(($estabelecimentos));
    }
}
