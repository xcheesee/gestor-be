<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DevolucaoFormRequest extends FormRequest
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
            'data_devolucao' => 'required',
            //'data_devolucao' => 'required|date_format:Y-m-d',
            'numero_devolucao' => 'required',
            'valor' => 'required',
            //'valor' => ['required', 'regex:/^\d{1,13}(\.\d{1,2})?$/'],
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'date_format' => "O valor do campo :attribute deve ser um data no formato yyyy-mm-dd",
            'valor.regex' => "O valor do campo :attribute tem limite de 100000000000000 (Cem Trilhões)"
        ];
    }
}
