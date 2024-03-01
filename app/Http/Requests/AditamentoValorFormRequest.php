<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AditamentoValorFormRequest extends FormRequest
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
            'valor_aditamento' => ['required', 'regex:/^\d{1,16}(\.\d{1,2})?$/'],
            'tipo_aditamento' => 'nullable|in:Acréscimo de valor,Redução de valor',
            'data_aditamento' => 'nullable|date_format:Y-m-d',

        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'tipo_aditamento.in' => "Valores possíveis para tipo aditamento: 'Acréscimo de valor', 'Redução de valor'",
            'date_format' => "O valor do campo :attribute deve ser um data no formato yyyy-mm-dd",
            'valor_aditamento.regex' => "O valor do campo :attribute tem limite de 100000000000000 (Cem Trilhões)",
            'valor_aditamento.required' => 'O valor de campo Valor Aditamento deve ser no minimo 0'
        ];
    }
}
