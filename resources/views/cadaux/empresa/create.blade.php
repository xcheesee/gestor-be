@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Nova Empresa', 'rota' => 'cadaux-empresas'])
@endsection

@section('conteudo')
@include('layouts.erros', ['errors' => $errors])
<div class="container containerTabela justify-content-center">
    <div class="container mb-3">
        <p class="form-legenda"><em>Campos com asterisco (*) são obrigatórios</em></p>
    </div>
    <div class="container">
        {!! Form::open(array('route' => 'cadaux-empresas-store','method'=>'POST')) !!}
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Nome: </strong></label>
                {!! Form::text('nome', null, array('placeholder' => 'Nome completo da Empresa','class' => 'form-control','required','maxlength'=>255)) !!}
            </div>
            <div class="form-group mb-3">
                <label for="numdoc" class="control-label"><strong>CNPJ: </strong></label>
                {!! Form::text('cnpj', null, array('id'=>'numdoc','placeholder' => '00.000.000/0000-0','class' => 'form-control cnpj',)) !!}
            </div>
            <div class="form-group mb-3">
                <label for="email" class="control-label"><strong>E-mail: </strong></label>
                {!! Form::text('email', null, array('placeholder' => 'Endereço de E-mail','id'=>'email','class' => 'form-control','required')) !!}
            </div>
            <div class="col form-group mb-3">
                <label for="telefone" class="control-label"><strong>Telefone Fixo: </strong></label>
                {!! Form::text('telefone', null, array('placeholder' => '(11) 1234-5678','id'=>'telefone','class' => 'form-control phone','required')) !!}
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        {!! Form::close() !!}
    </div>
</div>

@include('utilitarios.scripts')
@endsection
