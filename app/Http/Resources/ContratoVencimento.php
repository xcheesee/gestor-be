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
            'nome_empresa' => $this->empresa ? $this->empresa->nome : null,
            'telefone_empresa' => $this->empresa ? $this->empresa->telefone : null,
            'email_empresa' => $this->empresa ? $this->empresa->email : null,
            'dias_ate_vencimento' => $this->dias_ate_vencimento,
            'meses_ate_vencimento' => $this->meses_ate_vencimento,
        ];
    }
}
