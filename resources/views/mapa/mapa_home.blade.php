@extends('layouts.base')

@section('content')

    @extends('layouts.partial.header')

    <div class="container">
        <h1>Mapa</h1>
        <div class="row col-md-12">
            <form method="post" action="{{route('mapa.store')}}">
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id" name="id">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>

                <button type="submit" class="btn btn-success">Novo</button>
                <button type="reset" class="btn btn-danger">Resetar</button>
            </form>
        </div>


        <div class="row col-md-12">
            <table id="mapas" class="table table-bordered table-responsive">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mapas as $key => $mapa)
                    <tr>
                        <td>{{$mapa['id']}}</td>
                        <td>{{$mapa['nome']}}</td>
                        <td>
                            <button onclick="editar('{{$mapa['id']}}','{{$mapa['nome']}}'  )" class="btn btn-primary">Editar</button>
                            <a href="{{route('mapa.conceitos', $mapa['id'])}}" class="btn btn-success">Conceitos</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#mapas').DataTable();
        });

        function editar(id, nome) {
            $('#id').val(id);
            $('#nome').val(nome);
        }
    </script>
@endsection