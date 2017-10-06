@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Conceitos</h1>
        <div class="row col-md-12">
            <form method="post" action="{{route('conceito.store')}}">
                <div class="form-group">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="deletar" name="deletar">
                    <label for="nome">Nome:</label>
                    <input type="text" class="form-control" id="nome" name="nome">
                </div>

                <button id="button_novo" type="submit" class="btn btn-success">Novo</button>
                <button id="button_resetar" type="reset" class="btn btn-warning" onclick="resetar();"
                        style="display: none">Resetar
                </button>
                <button id="button_apagar" type="submit" class="btn btn-danger" onclick="apagar();"
                        style="display: none">Apagar
                </button>
            </form>
        </div>


        <div class="row col-md-12">
            <table id="conceitos" class="table table-bordered table-responsive" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>#</th>
                </tr>
                </thead>
                <tbody>
                @foreach($conceitos as $key => $conceito)
                    <tr>
                        <td>{{$conceito['id']}}</td>
                        <td>{{$conceito['nome']}}</td>
                        <td>
                            <button onclick="editar('{{$conceito['id']}}','{{$conceito['nome']}}'  )"
                                    class="btn btn-primary">Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <script>
        $(document).ready(function () {
            $('#conceitos').DataTable();
        });

        function editar(id, nome) {
            $('#id').val(id);
            $('#nome').val(nome);
            $('#button_novo').text("Editar");
            $('#button_resetar').css("display", "inline");
            $('#button_apagar').css("display", "inline");
        }

        function resetar() {
            $('#button_novo').text("Novo");
            $('#button_resetar').css("display", "none");
            $('#button_apagar').css("display", "none");
        }

        function apagar() {
            $('#deletar').val("1");
        }
    </script>


@endsection