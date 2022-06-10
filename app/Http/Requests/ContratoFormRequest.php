<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'processo_sei' => 'required',
            'dotacao_orcamentaria' => 'required',
            'credor' => 'required',
            'cnpj_cpf' => 'required',
            'objeto' => 'required',
            'numero_contrato' => 'required',
            'valor_contrato' => 'required',
            'data_inicio_vigencia' => 'required',
            'condicao_pagamento' => 'required',
            'nome_empresa' => 'required',
            'telefone_empresa' => 'required',
            'email_empresa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
        ];
    }
}
