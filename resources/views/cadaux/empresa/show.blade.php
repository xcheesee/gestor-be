@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dados da Empresa', 'rota' => 'cadaux-empresas'])
@endsection

@section('conteudo')
<div class="container containerTabela justify-content-center">
    <div class="row">
        <div class="col col-9 mb-3">
            <h4>Empresa ID {{ $empresa->id }}</h4>
        </div>
        <div class="col col-3 text-end mb-3">
            <a class="btn btn-success" href="{{ route('cadaux-empresas-edit',$empresa->id) }}"><i class="fas fa-edit"></i> Editar</a>
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Nome:</strong>
            {{ $empresa->nome }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>CNPJ:</strong>
            {{ $empresa->cnpj_formatado }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>Telefone:</strong>
            {{ $empresa->telefone }}
        </div>
    </div>
    <div class="row">
        <div class="col mb-3">
            <strong>E-mail:</strong>
            {{ $empresa->email }}
        </div>
    </div>
</div>
@endsection
