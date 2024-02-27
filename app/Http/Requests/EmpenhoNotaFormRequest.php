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
            'tipo_empenho' => 'nullable|in:complemento,cancelamento,novo_empenho',
            'numero_nota' => 'nullable|integer',
            'data_emissao' => 'nullable|date_format:Y-m-d',
            'valor_empenho' => 'required',
            'mes_referencia' => 'required',
            'ano_referencia' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'tipo_empenho.in' => "Valores possíveis para tipo empenho: 'complemento', 'cancelamento', 'novo_empenho",
            'integer' => "O valor do campo ':attribute' deve ser um número inteiro",
            'date_format' => "O valor do campo :attribute deve ser um data no formato yyyy-mm-dd"
        ];
    }
}
