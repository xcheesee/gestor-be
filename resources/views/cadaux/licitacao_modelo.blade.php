@extends('layouts.base')

@section('cabecalho')
    @include('layouts.cabecalho', ['titulo' => 'Modalidades de Licitação', 'rota' => 'cadaux'])
@endsection

@section('conteudo')
@include('layouts.mensagem', ['mensagem' => $mensagem])
@include('layouts.erros', ['errors' => $errors])

<div class="row d-flex justify-content-center mt-3 containerTabela">
    <div class="row d-flex">
        <div class="col-8">
        </div>
        <div class="col-4 text-end">
            <button class="btn btn-success" onclick="scrollToNewForm('newform')">Nova Modalidade de Licitação</a>
        </div>
    </div>
    <div class="row">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <th class="col-sm-1">ID</th>
                    <th class="col-md-6">Nome</th>
                    <th class="col-md-1 text-end">Ação</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($licitacao_modelos as $key => $licitacao_modelo)
                    <tr>
                        <td>{{ $licitacao_modelo->id }}</td>
                        <td>
                            <span id="nome-{{ $licitacao_modelo->id }}">{{ $licitacao_modelo->nome }}</span>
                            <div class="input-group w-50" hidden id="input-nome-{{ $licitacao_modelo->id }}">
                                <input type="text" class="form-control" value="{{ $licitacao_modelo->nome }}">
                            </div>
                        </td>
                        <td>
                            <span class="d-flex flex-row-reverse">
                                <span id="btn-edit-{{ $licitacao_modelo->id }}" >
                                    <button class="btn btn-success" onclick="toggleInput({{ $licitacao_modelo->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </span>
                                <div id="btn-submit-{{ $licitacao_modelo->id }}" hidden>
                                    <button class="btn btn-success" onclick="editarOrigemRecurso({{ $licitacao_modelo->id }})">
                                        <i class="fas fa-check"></i>
                                    </button>
                                    @csrf
                                </div>
                            </span>
                            @can('licitacao_modelo-editar')
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="newform" class="row d-flex justify-content-center mt-3 containerTabela">
    <h4>Nova Modalidade de Licitação</h4>
    <form method="post" enctype="multipart/form-data">
        @csrf
        <div class="row">

            <div class="form-group required mt-3">
                <label class="control-label" for="nome"><strong>Nome: </strong></label>
                <input type="text" class="inputForm form-control" name="nome">
            </div>
        </div>
        <button class="btn btn-success mt-3 btnForm"><i class="far fa-criar"></i> Criar</button>
    </form>
</div>

<script>
    function scrollToNewForm(id){
        var element = document.querySelector(`#${id}`);
        //element.style.visibility = 'visible'; //style="visibility: hidden !important;"

        // scroll to element
        element.scrollIntoView({ behavior: 'smooth', block: 'start'});
    }

    function toggleInput(Id) {
        const nomeEl = document.getElementById(`nome-${Id}`);
        const inputnomeEl = document.getElementById(`input-nome-${Id}`);
        const btnEl = document.getElementById(`btn-edit-${Id}`);
        const subEl = document.getElementById(`btn-submit-${Id}`);
        if (nomeEl.hasAttribute('hidden')) {
            nomeEl.removeAttribute('hidden');
            inputnomeEl.hidden = true;
            subEl.hidden = true;
        } else {
            inputnomeEl.removeAttribute('hidden');
            subEl.removeAttribute('hidden');
            nomeEl.hidden = true;
        }
    }

    function editarOrigemRecurso(Id) {
        let formData = new FormData();
        const nome = document.querySelector(`#input-nome-${Id} > input`).value;
        const token = document.querySelector('input[name="_token"]').value;
        formData.append('nome', nome);
        formData.append('_token', token);

        const url = '/{{ env('APP_FOLDER', 'contratos') }}/licitacao_modelos/'+Id;
        fetch(url, {
            body: formData,
            method: 'POST'
        }).then(function(response) {
            if(response.ok){
                toggleInput(Id);
                document.getElementById(`nome-${Id}`).textContent = nome;
            }else{
                response.json().then(data => {
                    alert(data.mensagem);
                });
            }
        });
    }
</script>
@endsection
