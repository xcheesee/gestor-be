@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Cadastros Auxiliares', 'rota' => 'home'])
@endsection

@section('conteudo')
<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex justify-content-center mt-3 containerTabela">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-12 border-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('cadaux-origem_recursos') }}" class="list-group-item list-group-item-action">Fontes de Recurso</a>
                    <a href="{{ route('cadaux-dotacao_tipos') }}" class="list-group-item list-group-item-action">Tipos de Dotação</a>
                    <a href="{{ route('cadaux-licitacao_modelos') }}" class="list-group-item list-group-item-action">Modalidades de Licitação</a>
                    <a href="{{ route('cadaux-distritos') }}" class="list-group-item list-group-item-action">Distritos</a>
                    <a href="{{ route('cadaux-empresas') }}" class="list-group-item list-group-item-action">Empresas</a>
                    <a href="{{ route('cadaux-subprefeituras') }}" class="list-group-item list-group-item-action">Subprefeituras</a>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
