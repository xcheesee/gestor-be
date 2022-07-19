@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Editar Tipo de Dotação', 'rota' => 'cadaux-dotacao_tipos'])
@endsection

@section('conteudo')
@include('layouts.erros', ['errors' => $errors])
<div class="container containerTabela justify-content-center">
    <div class="container mb-3">
        <p class="form-legenda"><em>Campos com asterisco (*) são obrigatórios</em></p>
    </div>
    <div class="container">
        {!! Form::model($dotacao_tipo, ['route' => ['cadaux-dotacao_tipos-update', $dotacao_tipo->id], 'method'=>'POST']) !!}
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Número da Dotação: </strong></label>
                {!! Form::text('numero_dotacao', null, array('placeholder' => '00.00.00.000.0000.0.000.00000000.00.0','class' => 'form-control dotacao','required')) !!}
            </div>
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Descrição da Ação da Dotação: </strong></label>
                {!! Form::text('descricao', null, array('placeholder' => 'Descreva brevemente a ação deste número de dotação','class' => 'form-control','required','maxlength'=>255)) !!}
            </div>
            <div class="form-group required mb-3">
                <label class="control-label"><strong>Tipo de Despesa: </strong></label>
                {!! Form::text('tipo_despesa', null, array('placeholder' => 'Descreva brevemente o tipo da despesa a que se refere este número de dotação','class' => 'form-control','required','maxlength'=>255)) !!}
            </div>
            <button type="submit" class="btn btn-success">Salvar</button>
        {!! Form::close() !!}
    </div>
</div>

@include('utilitarios.scripts')
@endsection
