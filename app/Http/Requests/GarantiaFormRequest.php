<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GarantiaFormRequest extends FormRequest
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
            'valor_garantia' => ['required', 'regex:/^\d{1,16}(\.\d{1,2})?$/'],
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'valor_garantia.regex' => "O valor do campo :attribute tem limite de 100000000000000 (Cem Trilhões)"
        ];
    }
}
