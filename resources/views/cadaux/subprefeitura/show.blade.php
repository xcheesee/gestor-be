@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dados da Subprefeitura', 'rota' => 'cadaux-subprefeituras'])
@endsection

@section('conteudo')
<div class="container containerTabela justify-content-center">
    <div class="row">
        <div class="col col-9 mb-3">
            <h4>Subprefeitura ID {{ $subprefeitura->id }}</h4>
        </div>
        <div class="col col-3 text-end mb-3">
            <a class="btn btn-success" href="{{ route('cadaux-subprefeituras-edit',$subprefeitura->id) }}"><i class="fas fa-edit"></i> Editar</a>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Região:</strong>
            {{ $subprefeitura->regiao }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Nome:</strong>
            {{ $subprefeitura->nome }}
        </div>
    </div>
</div>
@endsection
