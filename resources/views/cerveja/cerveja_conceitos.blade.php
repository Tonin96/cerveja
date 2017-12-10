@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>Conceitos da Cerveja</h1>
        <div class="row col-md-12">
            <form method="post" action="{{route('cerveja_conceito.store')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" value="{{$cerveja['id']}}" name="cerveja_id">
                <input type="hidden" value="{{\App\Models\AbstracModel::CONCEITO_CONCEITO}}" name="tipo_conceito">
                <div class="form-group col-md-6">
                    <label for="conceito_id">Conceito: </label>
                    <select id="conceito_id" class="form-control" name="conceito_id">
                        <option value="">Selecione</option>
                        @foreach($conceitos as $key => $conceito)
                            <option value="{{$conceito->id}}">{{$conceito->nome}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-12">
                    <button class="btn btn-success form-control" type="submit">Adicionar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="row col-md-12">
            <table id="conceitos" class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>Conceito ID</th>
                    <th>Nome</th>
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($cerveja_conceitos as $key => $conceito)
                    <tr>
                        <td>{{$conceito->id}}</td>
                        <td>{{$conceito->nome}}</td>
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
            $('#conceito_id').select2();
        });
        $(document).ready(function () {
            $('#conceitos').DataTable();
        });
    </script>
@endsection