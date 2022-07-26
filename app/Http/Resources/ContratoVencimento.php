<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContratoVencimento extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'processo_sei' => $this->processo_sei,
            'cnpj_cpf' => $this->cnpj_cpf,
            'numero_contrato' => $this->numero_contrato,
            'data_vencimento' => $this->data_vencimento,
            'nome_empresa' => $this->nome_empresa,
            'telefone_empresa' => $this->telefone_empresa,
            'email_empresa' => $this->email_empresa,
            'dias_ate_vencimento' => $this->dias_ate_vencimento,
            'meses_ate_vencimento' => $this->meses_ate_vencimento,
        ];
    }
}
