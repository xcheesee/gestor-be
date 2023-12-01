@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dashboard', 'rota' => 'home'])
@endsection

@section('conteudo')

@include('layouts.mensagem', ['mensagem' => $mensagem])
<div class="row d-flex justify-content-center mt-3 containerTabela" style="min-height: 600px;">
    <form method="GET">
        <div class="row align-items-end">
            <div class="col col-3 mb-2">
                <label for="f-ano_pesquisa" class="col-form-label">Ano</label>
                <div class="d-flex">
                    <input type="text" class="form-control" id="f-ano_pesquisa" name="f-ano_pesquisa" placeholder="Ano de pesquisa" value="{{$filtros['ano_pesquisa']}}">
                    <button type="button" class="btn bg-transparent" style="margin-left: -40px; z-index: 100;" onclick="$(this).siblings('input[type=\'text\']').val('')"><i class="fa fa-times"></i></button>
                </div>
            </div>
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
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Contratos</h5>
                    <p class="card-text">{{ $contratos['total'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Aquisições</h5>
                    <p class="card-text">{{ $contratos['aquisição'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Serviços</h5>
                    <p class="card-text">{{ $contratos['serviço'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Obras</h5>
                    <p class="card-text">{{ $contratos['obra'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-secondary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Projetos</h5>
                    <p class="card-text">{{ $contratos['projeto'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card bg-info mb-3">
                <div class="card-body">
                    <h5 class="card-title">Iniciados</h5>
                    <p class="card-text">{{ $contratos['iniciados'] }}</p>
                </div>
            </div>
        </div>
        <div class="col d-grid gap-2">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body">
                    <h5 class="card-title">Vencidos</h5>
                    <p class="card-text">{{ $contratos['vencidos'] }}</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div class="col d-grid gap-2" style="height: 400px;">
            {!! $chart1->container() !!}
        </div>
        <div class="col d-grid gap-2" style="height: 400px;">
            {!! $chart2->container() !!}
        </div>
        <div class="col d-grid gap-2" style="height: 400px;">
            {!! $chart3->container() !!}
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div class="col col-10 d-grid gap-2" style="height: 400px;">
            {!! $chart4->container() !!}
        </div>
    </div>
    <div class="row d-flex justify-content-center m-3" style="height: 400px;">
        <div class="col col-10 d-grid gap-2" style="height: 400px;">
            {!! $chart5->container() !!}
        </div>
    </div>
</div>


<script src="{{ asset('js/apexcharts.js') }}"></script>

{{ $chart1->script() }}
{{ $chart4->script() }}

@include('utilitarios.charts', ['chart' => $chart2])
@include('utilitarios.charts', ['chart' => $chart3])
@include('utilitarios.charts_multi', ['chart' => $chart5])
@endsection
