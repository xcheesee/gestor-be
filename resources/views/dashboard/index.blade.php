@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dashboard', 'rota' => 'home'])
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
        <div class="col d-grid gap-2">
            <div class="card bg-success mb-3" data-toggle="tooltip" data-placement="top" title="Total de contratos ativos no sistema">
                <div class="card-body">
                    <h5 class="card-title">Ativos</h5>
                    <p class="card-text">{{ $contratos['ativos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-warning mb-3" data-toggle="tooltip" data-placement="top" title="Total de Contratos que vencerão em 90 dias">
                <div class="card-body">
                    <h5 class="card-title">Vence em 90 dias</h5>
                    <p class="card-text">{{ $contratos['venc90'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-secondary mb-3" data-toggle="tooltip" data-placement="top" title="Total de Contratos que vencerão em 30 dias">
                <div class="card-body">
                    <h5 class="card-title">Vence em 30 dias</h5>
                    <p class="card-text">{{ $contratos['venc30'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card text-white bg-danger mb-3" data-toggle="tooltip" data-placement="top" title="Contratos ativos e que expiraram a data de vencimento">
                <div class="card-body">
                    <h5 class="card-title">Vencidos</h5>
                    <p class="card-text">{{ $contratos['vencidos'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-light mb-3" data-toggle="tooltip" data-placement="top" title="Contratos firmados em ordem de início com data de vigência registrada">
                <div class="card-body">
                    <h5 class="card-title">Iniciados</h5>
                    <p class="card-text">{{ $contratos['iniciados'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card text-white bg-dark mb-3" data-toggle="tooltip" data-placement="top" title="Contratos firmados em ordem de início no último mês">
                <div class="card-body">
                    <h5 class="card-title">Recentes</h5>
                    <p class="card-text">{{ $contratos['recentes'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card text-white bg-primary mb-3" data-toggle="tooltip" data-placement="top" title="Contratos com Status marcado como Finalizado">
                <div class="card-body">
                    <h5 class="card-title">Finalizados</h5>
                    <p class="card-text">{{ $contratos['finalizados'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div id="chart1" class="col d-grid gap-2" style="width: 600px; height: 400px;">
        </div>
        <div id="chart2" class="col d-grid gap-2" style="height: 400px;">
        </div>
        <div id="chart3" class="col d-grid gap-2" style="height: 400px;">
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div id="chart4" class="col col-10 d-grid gap-2" style="height: 400px;">
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div id="chart5" class="col col-10 d-grid gap-2" style="height: 400px;">
        </div>
    </div>
</div>

@include('utilitarios.scripts')

@include('dashboard.charts.chart_basic', ['div_id'=>'chart1','options' => $chart1])
@include('dashboard.charts.chart_basic', ['div_id'=>'chart2','options' => $chart2])
@include('dashboard.charts.chart_basic', ['div_id'=>'chart3','options' => $chart3])
@include('dashboard.charts.chart_money', ['div_id'=>'chart4','options' => $chart4])
@include('dashboard.charts.chart_basic', ['div_id'=>'chart5','options' => $chart5])

@endsection
