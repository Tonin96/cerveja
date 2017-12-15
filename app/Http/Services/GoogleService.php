<?php

namespace App\Http\Services;

use App\Models\Conceito;
use GoogleMaps\GoogleMaps;
use Illuminate\Http\Request;

class GoogleService {

    private $types = array('bar', 'cafe', 'night_club', 'casino', 'restaurant');
    private $google_maps_service;

    public function __construct(GoogleMaps $google_maps_service) {
        $this->google_maps_service = $google_maps_service;
    }

    public function getEstalecimentosByPosition(String $latitude, String $longitude, String $radius) {

        $location = array($latitude, $longitude);

        $location = implode(",", $location);
        $estabelecimentos = array();

        foreach ($this->types as $type) {
            $response = $this->google_maps_service->load('nearbysearch')
                ->setParam(['location' => $location])
                ->setParam(['radius' => $radius])
                ->setParam(['type' => $type])
                ->setParam(['opennow' => 'opennow'])
                ->get(true);
            $estabelecimentos = array_merge($estabelecimentos, $response['results']);
        }

        return response()->json(($estabelecimentos));
    }

    public function getEstabelecimentoById(String $place_id) {
        $response = $this->google_maps_service->load('placedetails')
            ->setParam(['placeid' => $place_id])
            ->get(true);


        return $response['result'];
    }
}
