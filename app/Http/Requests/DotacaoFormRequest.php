<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DotacaoFormRequest extends FormRequest
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
            //'dotacao_tipo_id' => 'required',
            'contrato_id' => 'required',
            //'valor_dotacao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
        ];
    }
}
