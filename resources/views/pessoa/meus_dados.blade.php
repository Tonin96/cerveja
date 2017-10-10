@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Meus Dados</h2>
    <form id="form_meus_dados" method="post" class="form-horizontal" action="{{route('pessoa.salvar_dados')}}">
        <div class="form-group">
            <input class="hidden" name="id" value="{{$pessoa['id']}}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="col-md-6">
                <label for="input_email" class="control-label">Email</label>
                <input type="email" class="form-control" id="input_email" placeholder="Email" name="email" value="{{$pessoa['email']}}" required>
            </div>

            <label for="input_tel" class="control-label">Telefone</label>
            <div class="col-md-6">
                <input type="tel" class="form-control" id="input_tel" placeholder="Telefone" name="telefone" value="{{$pessoa['telefone']}}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <label for="input_cpf" class="control-label">CPF</label>
                <input type="text" class="form-control" id="input_cpf" placeholder="Cpf" name="cpf" value="{{$pessoa['cpf']}}" required>
            </div>
            <div class="col-md-6">
                <label>Data de Nascimento</label>
                <input type="date" class="form-control" id="input_data_nascimento" placeholder="Data de Nascimento" name="data_nascimento" value="{{$pessoa['data_nascimento']}}" required>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <button type="submit" class="btn btn-success">Salvar</button>
            </div>
        </div>
    </form>
    </div>

    <script>
        $('#input_cpf').mask('000.000.000-00', {reverse: false});
        $('#input_tel').mask('(00) 00000-0000');
    </script>

@endsection