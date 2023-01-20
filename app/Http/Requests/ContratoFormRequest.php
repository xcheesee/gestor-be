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
            'departamento_id' => 'required',
            'telefone_empresa' => ["regex:/^(?:(?:\+|00)?(55)\s?)?(?:\(?([1-9][0-9])\)?\s?)?(?:((?:9\d|[2-9])\d{3})\-?(\d{4}))$/"],
            'tipo_objeto' => 'nullable|in:obra,projeto,serviço,aquisição',
            'email_empresa' => 'email',
           //'credor' => 'required',
           //'cnpj_cpf' => 'required|cpf_ou_cnpj',
           //'objeto' => 'required',
           //'numero_contrato' => 'required',
           //'valor_contrato' => 'required',
           //'data_inicio_vigencia' => 'required',
           //'condicao_pagamento' => 'required',
           //'nome_empresa' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'tipo_objeto.in' => "Valores possíveis para tipo de objeto: 'obra','projeto','serviço','aquisição'",
            'telefone_empresa.regex' => "Formato inválido para telefone",
            'email' => "O campo ':attribute' precisa ser um e-mail válido",
        ];
    }
}
