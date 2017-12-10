@extends('layouts.app')

@section('content')

    <div class="container">
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
                        <a href="{{route('pessoa.indexConceitos', $pessoa['id'])}}" class="btn btn-primary">Conceitos</a>
                    </td>
                </tr>
            @endforeach

            </tbody>
        </table>
        <button class="btn btn-primary">Novo</button>
    </div>

    <script>
        $(document).ready(function () {
            $('#pessoas').DataTable();
        });
    </script>


@endsection