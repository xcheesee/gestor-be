@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dashboards', 'rota' => 'home'])
@endsection

@section('conteudo')
<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex justify-content-center mt-3 containerTabela">
        <ul class="list-group list-group-horizontal">
            <li class="list-group-item col-md-12 border-0">
                <div class="list-group list-group-flush">
                    <a href="{{ route('dashboard-geral') }}" class="list-group-item list-group-item-action">Visão Geral</a>
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action disabled">Visão Orçamentária</a>
                    <a href="{{ route('dashboard') }}" class="list-group-item list-group-item-action disabled">Visão Unidades</a>
                    <a href="{{ route('dashboard-empresas') }}" class="list-group-item list-group-item-action">Visão Empresas</a>
                </div>
            </li>
        </ul>
    </div>
</div>
@endsection
