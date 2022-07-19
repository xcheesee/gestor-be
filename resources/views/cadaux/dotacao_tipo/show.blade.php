@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dados do Tipo de Dotação', 'rota' => 'cadaux-dotacao_tipos'])
@endsection

@section('conteudo')
<div class="container containerTabela justify-content-center">
    <div class="row">
        <div class="col col-9 mb-3">
            <h4>Tipo Dotação ID {{ $dotacao_tipo->id }}</h4>
        </div>
        <div class="col col-3 text-end mb-3">
            <a class="btn btn-success" href="{{ route('cadaux-dotacao_tipos-edit',$dotacao_tipo->id) }}"><i class="fas fa-edit"></i> Editar</a>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Número da Dotação:</strong>
            {{ $dotacao_tipo->numero_dotacao }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Descrição da Ação da Dotação:</strong>
            {{ $dotacao_tipo->descricao }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Tipo de Despesa:</strong>
            {!! $dotacao_tipo->tipo_despesa !!}
        </div>
    </div>
</div>
@endsection
