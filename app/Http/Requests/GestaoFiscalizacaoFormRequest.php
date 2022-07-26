<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GestaoFiscalizacaoFormRequest extends FormRequest
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
            'email_gestor' => 'required|email',
            'email_fiscal' => 'nullable|email',
            'email_suplente' => 'nullable|email'
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'email' => "O campo ':attribute' precisa ser um e-mail válido",
        ];
    }
}
