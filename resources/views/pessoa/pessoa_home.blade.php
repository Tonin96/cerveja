@extends('layouts.base')

@section('content')

    @extends('layouts.partial.header')



    <h1>Pessoas</h1>
    <table id="pessoas" class="table table-bordered table-responsive" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nome</th>
            <th>#</th>
        </tr>
        </thead>
        <tbody>
        @foreach($pessoas as $key => $pessoa)
            <tr>
                <td>{{$pessoa['id']}}</td>
                <td>{{$pessoa['nome']}}</td>
                <td>
                    <button class="btn">Editar</button>
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    <button class="btn btn-primary">Novo</button>

    <script>
        $(document).ready(function () {
            $('#pessoas').DataTable();
        });
    </script>


@endsection