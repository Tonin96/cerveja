@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>{{$pessoa->nome}}</h2>
        <div class="row col-md-12">
            <form method="post" action="{{route('pessoa.storeConceito')}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="pessoa_id" value="{{$pessoa->id}}">
                <div class="form-group col-md-6">
                    <label for="conceito_id" class="control-label">Conceitos</label>
                    <select id="conceito_id" name="conceito_id" class="form-control">
                        <option value="">Selecione</option>
                        @foreach($conceitos as $key => $conceito)
                            <option value="{{$conceito->id}}">{{$conceito->nome}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-success">Adicionar</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-md-12">
            <table id="conceitos_pessoa" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Conceito</th>
                </tr>
                </thead>
                <tbody>
                @foreach($conceitos_pessoa as $key => $conceito)
                    <tr>
                        <td>{{$conceito->id}}</td>
                        <td>{{$conceito->nome}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#conceitos').select2();
            $('#conceitos_pessoa').DataTable();

        });

    </script>

@endsection