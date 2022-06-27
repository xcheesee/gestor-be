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
            'tipo_aditamentos' => 'in:Acréscimo de valor,Redução de valor,Suspensão,Rescisão',

        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'tipo_aditamentos.in' => "Valores possíveis para tipo aditamento: 'Acréscimo de valor', 'Redução de valor', 'Prorrogação de valor', 'Supressão de prazo', 'Suspensão' e 'Rescisão'"
        ];
    }
}
