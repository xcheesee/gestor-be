@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Editar Subprefeitura', 'rota' => 'cadaux-subprefeituras'])
@endsection

@section('conteudo')
@include('layouts.erros', ['errors' => $errors])
<div class="container containerTabela justify-content-center">
    <div class="container mb-3">
        <p class="form-legenda"><em>Campos com asterisco (*) são obrigatórios</em></p>
    </div>
    <div class="container">
        {!! Form::model($subprefeitura, ['route' => ['cadaux-subprefeituras-update', $subprefeitura->id], 'method'=>'POST']) !!}
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Região: </strong></label>
                {!! Form::select('regiao', $regioes, $subprefeitura->regiao, array('class' => 'form-select','required','placeholder' => '-- Selecione --')) !!}
            </div>
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Nome: </strong></label>
                {!! Form::text('nome', null, array('placeholder' => 'Nome completo da Subprefeitura','class' => 'form-control','required','maxlength'=>255)) !!}
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        {!! Form::close() !!}
    </div>
</div>

@include('utilitarios.scripts')
@endsection
