@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Conceitos do Mapa</h1>
        <div class="row col-md-12">
            <form method="post" action="{{route('mapa_conceito.store')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$mapa_id}}" name="mapa_id">
                <div class="form-group col-md-6">
                    <label for="conceito_origem">Conceito Origem: </label>
                    <select id="conceito_origem" class="form-control" name="conceito_origem_id">
                        <option value="">Selecione</option>
                        @foreach($conceitos as $key => $conceito)
                            <option value="{{$conceito->id}}">{{$conceito->nome}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-6">
                    <label for="conceito_destino">Conceito Destino</label>
                    <select id="conceito_destino" class="form-control" name="conceito_destino_id">
                        <option value="">Selecione</option>
                        @foreach($conceitos_livres as $key => $conceito)
                            <option value="{{$conceito->id}}">{{$conceito->nome}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <button class="btn btn-success form-control" type="submit">Novo</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="row col-md-12">
            <table id="conceitos" class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>Origem</th>
                    <th>Destino</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($conceitos_mapa as $key => $conceito)
                    <tr>
                        <td>{{$conceito['origem_nome']}}</td>
                        <td>{{$conceito['destino_nome']}}</td>
                        <td>
                            <!--<button class="btn btn-primary">Editar</button>-->
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#conceito_origem').select2();
            $('#conceito_destino').select2();
        });
        $(document).ready(function () {
            $('#conceitos').DataTable();
        });
    </script>
@endsection