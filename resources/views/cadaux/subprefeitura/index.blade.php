@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Subprefeituras', 'rota' => 'cadaux'])
@endsection

@section('conteudo')
@include('layouts.mensagem', ['mensagem' => $mensagem])

<div class="row d-flex justify-content-center mt-3 containerTabela">
    <form class="form-inline" method="GET">
        <div class="row align-items-end">
            <div class="col col-3 mb-2">
                <label for="f-regiao" class="col-form-label">Região</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-regiao" name="f-regiao" placeholder="N,S,L ou CO" value="{{$filtros['regiao']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="col col-3 mb-2">
                <label for="f-nome" class="col-form-label">Nome</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-nome" name="f-nome" placeholder="Parte do nome da Subprefeitura" value="{{$filtros['nome']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
        <div class="row align-items-end mb-2">
            <div class="col col-3 mb-2">
                <button type="submit" class="btn btn-success btnForm"><i class="fas fa-filter"></i> Filtrar</button>
            </div>
            <div class="col col-6"></div>
            <div class="col col-3 text-end">
                <a class="btn btn-success" href="{{ route('cadaux-subprefeituras-create') }}"><i class="fas fa-file"></i> Nova Subprefeitura</a>
            </div>
        </div>
    </form>
    <div class="row">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="col-md-1">@sortablelink('id', 'ID')</th>
                    <th class="col-md-1">@sortablelink('regiao', 'Região')</th>
                    <th class="col-md-4">@sortablelink('nome', 'Nome')</th>
                    <th class="col-md-2">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $subprefeitura)
                    <tr>
                        <td>{{ $subprefeitura->id }}</td>
                        <td>{{ $subprefeitura->regiao }}</td>
                        <td>{!! $subprefeitura->nome !!}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('cadaux-subprefeituras-show',$subprefeitura->id) }}"><i class="far fa-eye"></i></a>
                            <a class="btn btn-success" href="{{ route('cadaux-subprefeituras-edit',$subprefeitura->id) }}"><i class="fas fa-edit"></i></a>
                            @can('permission-edit')
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $data->appends($_GET)->links() }}
    </div>
</div>
@endsection
