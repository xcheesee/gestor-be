@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dados do Distrito', 'rota' => 'cadaux-distritos'])
@endsection

@section('conteudo')
<div class="container containerTabela justify-content-center">
    <div class="row">
        <div class="col col-9 mb-3">
            <h4>Distrito ID {{ $distrito->id }}</h4>
        </div>
        <div class="col col-3 text-end mb-3">
            <a class="btn btn-success" href="{{ route('cadaux-distritos-edit',$distrito->id) }}"><i class="fas fa-edit"></i> Editar</a>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Subprefeitura:</strong>
            @if($distrito->subprefeitura) {{ $distrito->subprefeitura->nome }} @endif
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Nome:</strong>
            {{ $distrito->nome }}
        </div>
    </div>
</div>
@endsection
