@extends('layouts.app')

@section('content')

    <style>
        /* Always set the map height explicitly to define the size of the div
         * element that contains the map. */
        #map {
            height: 500px;
        }

    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div id="map"></div>
            </div>
            <div class="col-md-4">
                <div id="id_local" class="col-md-12 panel panel-default ">
                    <div class="panel-heading">

                        <h3 id="id_nome_local" class="panel-title">Panel title</h3>


                        <h4 id="id_nota"></h4>

                    </div>
                    <div class="panel-body">
                        <label><strong>Numero: </strong><label id="id_numero"></label></label>

                        <table id="id_comentarios" class="table table-condensed table-bordered">
                            <thead>
                            <tr>
                                <th>Avaliação</th>
                                <th>Comentario</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <form method="post" action="{{route('pessoa.beber')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" id="id_estabelecimento" name="estabelecimento_id" value="">

                            <div class="col-md-6">
                                <select class="form-control" name="cerveja_id">
                                    @foreach($cervejas as $key => $cerveja)
                                        <option value="{{$cerveja->id}}">{{$cerveja->nome}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-6">
                                <button class="btn btn-primary">Beber</button>
                            </div>
                        </form>
                        <form method="post" action="{{route('pessoa.recomendar')}}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <button class="btn btn-warning">Recomendação</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        var map;
        var current_pos;

        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 18,
                disableDefaultUI: true
            });
            var infoWindow = new google.maps.InfoWindow({map: map});

            // Try HTML5 geolocation.
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function (position) {
                    var pos = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };

                    infoWindow.setPosition(pos);
                    infoWindow.setContent('Você está aqui.');

                    current_pos = pos;
                    map.setCenter(pos);
                    $.post("{{route('google.estabelecimentos')}}", {
                        latitude: pos.lat,
                        longitude: pos.lng,
                        radius: 1500,
                        _token: '{{csrf_token()}}'
                    }, function (result) {
                        for (var i = 0; i < result.length; i++) {
                            createMarker(result[i]);
                        }
                    });

                    function createMarker(place) {
                        var placeLoc = place.geometry.location;
                        var marker = new google.maps.Marker({
                            map: map,
                            position: place.geometry.location
                        });

                        google.maps.event.addListener(marker, 'click', function () {
                            service = new google.maps.places.PlacesService(map);
                            service.getDetails(place, callback);
                        });

                        function callback(place, status) {
                            if (status == google.maps.places.PlacesServiceStatus.OK) {

                                console.log(place);
                                $('#id_nome_local').html(place.name);
                                $('#id_estabelecimento').val(place.place_id);
                                $('#id_numero').html(place.formatted_phone_number);
                                $('#id_nota').html('Nota: ' + place.rating);
                                $('#id_comentarios tbody').html('');
                                for (var i = 0; i < place.reviews.length; i++) {
                                    if (place.reviews[i].text != "") {
                                        var comentario = '<tr>';

                                        comentario += '<td class="text-center">' + place.reviews[i].rating + '</td>';
                                        comentario += '<td class="text-justify">' + place.reviews[i].text + '</td>';
                                        comentario += '</tr>';
                                        $('#id_comentarios > tbody:last-child').append(comentario);
                                    }

                                }
                                $('#id_local').removeClass('hidden');
                            }
                        }
                    }
                }, function () {
                    handleLocationError(true, infoWindow, map.getCenter());
                });
            } else {
                // Browser doesn't support Geolocation
                handleLocationError(false, infoWindow, map.getCenter());
            }


        }

        function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                'Error: The Geolocation service failed.' :
                'Error: Your browser doesn\'t support geolocation.');
        }


    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzAURwueY8RLgrWZNaMKb5q6nTO132Cx8&callback=initMap&libraries=places&callback=initMap"
    ></script>
@endsection
