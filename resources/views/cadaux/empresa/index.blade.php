@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Empresas', 'rota' => 'cadaux'])
@endsection

@section('conteudo')
@include('layouts.mensagem', ['mensagem' => $mensagem])

<div class="row d-flex justify-content-center mt-3 containerTabela">
    <form method="GET">
        <div class="row align-items-end">
            <div class="col col-3 mb-2">
                <label for="f-cnpj" class="col-form-label">CNPJ</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-cnpj" name="f-cnpj" placeholder="Número do CNPJ sem pontuação" value="{{$filtros['cnpj']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="col col-3 mb-2">
                <label for="f-nome" class="col-form-label">Nome</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-nome" name="f-nome" placeholder="Parte do nome da Empresa" value="{{$filtros['nome']}}">
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
                <a class="btn btn-success" href="{{ route('cadaux-empresas-create') }}"><i class="fas fa-file"></i> Nova Empresa</a>
            </div>
        </div>
    </form>
    <div class="row">
        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th class="col-md-1">@sortablelink('id', 'ID')</th>
                    <th class="col-md-3">@sortablelink('nome', 'Nome')</th>
                    <th class="col-md-2">@sortablelink('cnpj', 'CNPJ')</th>
                    <th class="col-md-2">@sortablelink('telefone', 'Telefone')</th>
                    <th class="col-md-2">@sortablelink('email', 'E-mail')</th>
                    <th class="col-md-2">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $empresa)
                    <tr>
                        <td>{{ $empresa->id }}</td>
                        <td>{!! $empresa->nome !!}</td>
                        <td>{!! $empresa->cnpj_formatado !!}</td>
                        <td>{!! $empresa->telefone !!}</td>
                        <td>{!! $empresa->email !!}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('cadaux-empresas-show',$empresa->id) }}"><i class="far fa-eye"></i></a>
                            <a class="btn btn-success" href="{{ route('cadaux-empresas-edit',$empresa->id) }}"><i class="fas fa-edit"></i></a>
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
