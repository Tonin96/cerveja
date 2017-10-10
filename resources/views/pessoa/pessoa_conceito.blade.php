@extends('layouts.app')

@section('content')

    <div class="container">
        <h2>{{$pessoa->nome}}</h2>
        <div class="row col-md-12">
            <form method="post">
                <div class="form-group col-md-6">
                    <label for="conceitos" class="control-label">Conceitos</label>
                    <select id="conceitos" name="conceitos" class="form-control">
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
                    <th>Opções</th>
                </tr>
                </thead>
                <tbody>
                @foreach($conceitos_pessoa as $key => $conceito)
                    <tr>
                        <td>{{$conceito['conceito_id']}}</td>
                        <td>{{$conceito['conceito_nome']}}</td>
                        <td>
                            <a href="" class="btn btn-danger">Excluir</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            $('#conceitos').select2();

        });

    </script>

@endsection