<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContratoNovoRequest extends FormRequest
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
            'departamento_id' => 'required',
            'processo_sei' => 'required|unique:App\Models\Contrato,processo_sei',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'processo_sei.unique' => 'Já existe um contrato cadastrado com este Processo no sistema',
        ];
    }
}
