@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Tipos de Dotação', 'rota' => 'cadaux'])
@endsection

@section('conteudo')
@include('layouts.mensagem', ['mensagem' => $mensagem])

<div class="row d-flex justify-content-center mt-3 containerTabela">
    <form class="form-inline" method="GET">
        <div class="row align-items-end">
            <div class="col col-3 mb-2">
                <label for="f_sigla" class="col-form-label">Número da Dotação</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-numero_dotacao" name="f-numero_dotacao" placeholder="00.00.00.000.0000.0.000.00000000.00.0" value="{{$filtros['numero_dotacao']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="col col-3 mb-2">
                <label for="f_sigla" class="col-form-label">Descrição</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-descricao" name="f-descricao" placeholder="Descrição da ação da dotação" value="{{$filtros['descricao']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <div class="col col-3 mb-2">
                <label for="f_nome" class="col-form-label">Tipo de Despesa</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-tipo_despesa" name="f-tipo_despesa" placeholder="Tipo de Despesa da dotação" value="{{$filtros['tipo_despesa']}}">
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
                <a class="btn btn-success" href="{{ route('cadaux-dotacao_tipos-create') }}"><i class="fas fa-file"></i> Novo tipo de Dotação</a>
            </div>
        </div>
    </form>
    <div class="row">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="col-md-1">@sortablelink('id', 'ID')</th>
                    <th class="col-md-2">@sortablelink('numero_dotacao', 'Nº Dotação')</th>
                    <th class="col-md-3">@sortablelink('descricao', 'Descrição')</th>
                    <th class="col-md-4">@sortablelink('tipo_despesa', 'Tipo de Despesa')</th>
                    <th class="col-md-2">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $key => $dotacao_tipo)
                    <tr>
                        <td>{{ $dotacao_tipo->id }}</td>
                        <td>{{ $dotacao_tipo->numero_dotacao }}</td>
                        <td>{{ $dotacao_tipo->descricao }}</td>
                        <td>{!! $dotacao_tipo->tipo_despesa !!}</td>
                        <td>
                            <a class="btn btn-success" href="{{ route('cadaux-dotacao_tipos-show',$dotacao_tipo->id) }}"><i class="far fa-eye"></i></a>
                            <a class="btn btn-success" href="{{ route('cadaux-dotacao_tipos-edit',$dotacao_tipo->id) }}"><i class="fas fa-edit"></i></a>
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
