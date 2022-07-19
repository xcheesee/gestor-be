<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpenhoNotaFormRequest extends FormRequest
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
            'numero_nota' => 'nullable|integer',
            'valor_empenho' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'integer' => "O valor do campo ':attribute' deve ser um número inteiro",
        ];
    }
}
