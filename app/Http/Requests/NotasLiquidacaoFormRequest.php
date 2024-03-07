<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotasLiquidacaoFormRequest extends FormRequest
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
            'contrato_id' => 'required',
            'data_pagamento' => 'required',
            //'data_pagamento' => 'required|date_format:Y-m-d',
            'mes_referencia' => 'required|integer',
            'ano_referencia' => 'required|integer',
            'valor' => 'required',
            //'valor' => ['required', 'regex:/^\d{1,16}(\.\d{1,2})?$/']
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'date_format' => "O campo :attribute deve ser no formato yyyy-mm-dd",
            //'valor.regex' => "O valor do campo :attribute tem limite de 100000000000000 (Cem Trilhões)",
        ];
    }
}
