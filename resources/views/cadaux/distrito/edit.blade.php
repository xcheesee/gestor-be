@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Editar Distrito', 'rota' => 'cadaux-distritos'])
@endsection

@section('conteudo')
@include('layouts.erros', ['errors' => $errors])
<div class="container containerTabela justify-content-center">
    <div class="container mb-3">
        <p class="form-legenda"><em>Campos com asterisco (*) são obrigatórios</em></p>
    </div>
    <div class="container">
        {!! Form::model($distrito, ['route' => ['cadaux-distritos-update', $distrito->id], 'method'=>'POST']) !!}
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Subprefeitura: </strong></label>
                {!! Form::select('subprefeitura_id', $subprefeituras, $distrito->subprefeitura_id, array('class' => 'form-select','required','placeholder' => '-- Selecione --')) !!}
            </div>
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Nome: </strong></label>
                {!! Form::text('nome', null, array('placeholder' => 'Nome completo do Distrito','class' => 'form-control','required','maxlength'=>255)) !!}
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        {!! Form::close() !!}
    </div>
</div>

@include('utilitarios.scripts')
@endsection
