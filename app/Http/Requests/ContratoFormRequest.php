<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use LaravelLegends\PtBrValidator\Rules\TelefoneComDdd;

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
            'credor' => 'required',
            'cnpj_cpf' => 'required',
            'tipo_objeto' => 'nullable|in:obra,projeto,serviço,aquisição',
            'objeto' => 'required',
            'numero_contrato' => 'required',
            'valor_contrato' => 'required',
            'data_inicio_vigencia' => 'required',
            'condicao_pagamento' => 'required',
            'nome_empresa' => 'required',
            'telefone_empresa' => 'required|telefone_com_ddd',
            'email_empresa' => 'required|email',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
        ];
    }
}
