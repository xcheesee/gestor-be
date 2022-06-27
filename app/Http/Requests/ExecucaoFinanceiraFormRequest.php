<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExecucaoFinanceiraFormRequest extends FormRequest
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
            'mes' => 'required|integer|max:12|min:1',
            'ano' => 'required|integer|min:2000',
            //'data_emissao_executado' => 'required',
            //'executado' => 'float',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'integer' => "O valor do campo ':attribute' deve ser um número inteiro",
            'mes.min' => "o valor de mês deve ser entre 1 a 12",
            'mes.max' => "o valor de mês deve ser entre 1 a 12",
            'ano.min' => "o valor de ano deve ser maior ou igual a 2000",
        ];
    }
}
