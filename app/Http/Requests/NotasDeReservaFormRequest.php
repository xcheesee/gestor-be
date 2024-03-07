<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotasDeReservaFormRequest extends FormRequest
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
            'numero_nota_reserva' => 'required',
            'data_emissao' => 'required',
            //'data_emissao' => 'required|date_format:Y-m-d',
            'tipo_nota' => 'required|in:nova,correcao,cancelamento,renovacao',
            'valor' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'required' => "O campo ':attribute' é obrigatório",
            'date_format' => "O campo :attribute deve ser no formato yyyy-mm-dd",
            'tipo_nota.in' => "Valores possiveis para tipo empenho: 'nova', 'correcao', 'cancelamento', 'renovacao'"
        ];
    }
}
