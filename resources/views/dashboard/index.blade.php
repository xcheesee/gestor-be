@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Dashboard', 'rota' => 'home'])
@endsection

@section('conteudo')

@include('layouts.mensagem', ['mensagem' => $mensagem])
<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex justify-content-center m-3" style="height: 600px;">
        <div class="col d-grid gap-2">
            {!! $chartCvE->container() !!}
        </div>
        <div class="col d-grid gap-2">
        </div>
    </div>
</div>

<script src="{{ asset('js/apexcharts.js') }}"></script>

{{ $chartCvE->script() }}
@endsection
