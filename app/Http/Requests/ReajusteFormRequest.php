<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReajusteFormRequest extends FormRequest
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
            'indice_reajuste' => 'required',
            'valor_reajuste' => 'required',
            //'data_reajuste' => 'nullable|date_format:Y-m-d',

        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'indice_reajuste.required' => "O Indice de reajuste deve ser no minimo 0",
            'valor_reajuste.required' => "O Valor de rejuste deve ser no minio 0",
            'date_format' => "A data deve ser no formato yyyy-mm-dd"
        ];
    }
}
