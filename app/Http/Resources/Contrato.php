<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contrato extends JsonResource
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
            'credor' => $this->credor,
            'cnpj_cpf' => $this->cnpj_cpf,
            'objeto' => $this->objeto,
            'numero_contrato' => $this->numero_contrato,
            'data_assinatura' => $this->data_assinatura,
            'valor_contrato' => $this->valor_contrato,
            'data_inicio_vigencia' => $this->data_inicio_vigencia,
            'data_fim_vigencia' => $this->data_fim_vigencia,
            'condicao_pagamento' => $this->condicao_pagamento,
            'prazo_contrato_meses' => $this->prazo_contrato_meses,
            'prazo_a_partir_de' => $this->prazo_a_partir_de,
            'data_prazo_maximo' => $this->data_prazo_maximo,
            'nome_empresa' => $this->nome_empresa,
            'telefone_empresa' => $this->telefone_empresa,
            'email_empresa' => $this->email_empresa,
            'outras_informacoes' => $this->outras_informacoes,
        ];
    }
}
