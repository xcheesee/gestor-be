@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Editar Usuário', 'rota' => 'users.index'])
@endsection

@section('conteudo')
@include('layouts.erros', ['errors' => $errors])
<div class="container containerTabela justify-content-center">
    <div class="container">
        {!! Form::model($user, ['route' => ['users.update', $user->id], 'method'=>'PATCH', 'autocomplete'=>"off"]) !!}
            <div class="form-group mb-3">
                <strong>Nome:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Login Rede:</strong>
                {!! Form::text('login', null, array('placeholder' => 'Login usado na rede interna (d000000 ou x000000)','class' => 'form-control', 'autocomplete'=>"off")) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Email:</strong>
                {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Departamentos:</strong>
                {!! Form::select('departamentos[]', $departamentos, $userDeptos, array('class' => 'form-control','multiple')) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Senha:</strong>
                {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control', 'autocomplete'=>"off")) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Confirmação Senha:</strong>
                {!! Form::password('password_confirmation', array('placeholder' => 'Confirm Password','class' => 'form-control', 'autocomplete'=>"off")) !!}
            </div>
            <div class="form-group mb-3">
                <strong>Perfis de Usuário:</strong>
                {!! Form::select('roles[]', $roles, $userRole, array('class' => 'form-control','multiple')) !!}
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        {!! Form::close() !!}
    </div>
</div>
<script>
    function getHiddenVal(){
        var value = $('#departamento_txt').val();
        var depto_id = $('#departamentos [value="' + value + '"]').data('value');
        $('#departamento_id').val(depto_id);
        //console.log($('#departamento').val());
    }
</script>
@endsection
