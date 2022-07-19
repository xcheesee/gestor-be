<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DotacaoTipoFormRequest extends FormRequest
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
            'numero_dotacao' => 'required|unique:App\Models\DotacaoTipo,numero_dotacao',
            'descricao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'numero_dotacao.unique' => "Já existe um tipo de dotação com este número, favor digitar outro número",
        ];
    }
}
