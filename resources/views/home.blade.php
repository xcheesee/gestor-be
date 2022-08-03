@extends('layouts.base')

@section('cabecalho')
    Menu Inicial
@endsection

@section('conteudo')

@include('layouts.mensagem', ['mensagem' => $mensagem])
<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex justify-content-center m-3" style="height: 200px;">
        @can('cadaux-list')
            <div class="col d-grid gap-2">
                <button onclick="location.href='{{ route('cadaux') }}'" class="btn btn-info"><i class="fas fa-database fa-7x"></i><br>Cadastros auxiliares</button>
            </div>
        @endcan
        @can('relatorio-show')
            <div class="col d-grid gap-2">
                <button onclick="location.href='{{ route('dashboard') }}'" class="btn btn-info"><i class="fa-solid fa-chart-pie fa-7x"></i><br>Dashboard</button>
            </div>
        @endcan
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 200px;">
        @can('user-list')
            <div class="col d-grid gap-2">
                <button onclick="location.href='{{ route('users.index') }}'" class="btn btn-info"><i class="fas fa-users-cog fa-7x"></i><br>Usuários</button>
            </div>
        @endcan
        @can('role-list')
            <div class="col d-grid gap-2">
                <button onclick="location.href='{{ route('roles.index') }}'" class="btn btn-info"><i class="fas fa-id-card fa-7x"></i><br>Perfis de Usuários</button>
            </div>
        @endcan
        @can('permission-list')
            <div class="col d-grid gap-2">
                <button onclick="location.href='{{ route('permissions.index') }}'" class="btn btn-info"><i class="fas fa-key fa-7x"></i><br>Permissões</button>
            </div>
        @endcan
    </div>
</div>
@endsection
