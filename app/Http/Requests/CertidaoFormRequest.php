<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CertidaoFormRequest extends FormRequest
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
            'certidoes' => 'required',
            'validade_certidoes' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório.",
            'certidoes.required' => "O campo de certidão é obrigatório.",
            'validade_certidoes.required' => "O campo validade de certidão é obrigatório."
        ];
    }
}