@extends('layouts.base')

@section('cabecalho')
    Menu Inicial
@endsection

@section('conteudo')

@include('layouts.mensagem', ['mensagem' => $mensagem])
<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex justify-content-center m-3" style="height: 200px;">
        <div class="col d-grid gap-2">
            <button onclick="location.href='{{ route('cadaux') }}'" class="btn btn-info"><i class="fas fa-database fa-7x"></i><br>Cadastros auxiliares</button>
        </div>
        <div class="col d-grid gap-2">
            <button onclick="location.href='{{ route('home') }}'" class="btn btn-info disabled"><i class="fas fa-folder-open fa-7x"></i><br>Relatórios</button>
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 200px;">
        <div class="col d-grid gap-2">
            @can('user-list')
                <button onclick="location.href='{{ route('users.index') }}'" class="btn btn-info"><i class="fas fa-users-cog fa-7x"></i><br>Usuários</button>
            @endcan
        </div>
        <div class="col d-grid gap-2">
            @can('role-list')
                <button onclick="location.href='{{ route('roles.index') }}'" class="btn btn-info"><i class="fas fa-id-card fa-7x"></i><br>Perfis de Usuários</button>
            @endcan
          </div>
        <div class="col d-grid gap-2">
            @can('permission-list')
                <button onclick="location.href='{{ route('permissions.index') }}'" class="btn btn-info"><i class="fas fa-key fa-7x"></i><br>Permissões</button>
            @endcan
        </div>
    </div>
</div>
@endsection
