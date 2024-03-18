@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Empresas', 'rota' => 'dashboard'])
@endsection

@section('conteudo')

@include('layouts.mensagem', ['mensagem' => $mensagem])
<div class="row d-flex justify-content-center mt-3 containerTabela" style="min-height: 600px;">
    <form method="GET">
        <div class="row align-items-end">
            {{-- <div class="col col-3 mb-2">
                <label for="f-ano_pesquisa" class="col-form-label">Ano</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-ano_pesquisa" name="f-ano_pesquisa" placeholder="Ano de pesquisa" value="{{$filtros['ano_pesquisa']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div> --}}
            <div class="col col-3 mb-2">
                <label for="f-ano_pesquisa" class="col-form-label">Departamento</label>
                <div class="d-flex">
                    {!! Form::select('f-departamento', $departamentos, $filtros['departamento'], array("placeholder"=>"-- Todos --","id"=>"f-departamento",'class' => 'form-select')) !!}
                </div>
            </div>
            <div class="col col-3 mb-2">
                <button type="submit" class="btn btn-success btnForm"><i class="fas fa-filter"></i> Definir</button>
            </div>
        </div>
    </form>
    <div class="row d-flex justify-content-center m-3" style="height: 120px;">
        <div class="col-2 d-grid gap-2">
            <div class="card bg-light mb-3" data-toggle="tooltip" data-placement="top" title="Total de empresas com contratos ativos no sistema">
                <div class="card-body">
                    <h5 class="card-title">Empresas com Contratos</h5>
                    <p class="card-text">{{ $contratos['empresas'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div id="chart5" class="col col-10 d-grid gap-2" style="height: 400px;">
        </div>
    </div>
</div>

@include('utilitarios.scripts')

@include('dashboard.charts.chart_basic', ['div_id'=>'chart5','options' => $chart5])

@endsection
