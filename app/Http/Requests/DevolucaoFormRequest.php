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
            'ano' => 'required|integer|min:2000',
            //'data_emissao_devolucao' => 'required',
            //'numero_devolucao' => 'integer',
            'valor_devolucao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'integer' => "O valor do campo ':attribute' deve ser um número inteiro",
            'ano.min' => "o valor de ano deve ser maior ou igual a 2000",
        ];
    }
}
