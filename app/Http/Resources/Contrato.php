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
            'tipo_contratacao_id' => $this->tipo_contratacao_id,
            'processo_sei' => $this->processo_sei,
            'dotacao_orcamentaria' => $this->dotacao_orcamentaria,
            'credor' => $this->credor,
            'cnpj_cpf' => $this->cnpj_cpf,
            'tipo_objeto' => $this->tipo_objeto,
            'objeto' => $this->objeto,
            'numero_contrato' => $this->numero_contrato,
            'data_assinatura' => $this->data_assinatura,
            'valor_contrato' => $this->valor_contrato,
            'valor_mensal_estimativo' => $this->valor_mensal_estimativo,
            'data_inicio_vigencia' => $this->data_inicio_vigencia,
            'data_vencimento' => $this->data_vencimento,
            'condicao_pagamento' => $this->condicao_pagamento,
            'prazo_a_partir_de' => $this->prazo_a_partir_de,
            'data_prazo_maximo' => $this->data_prazo_maximo,
            'nome_empresa' => $this->nome_empresa,
            'telefone_empresa' => $this->telefone_empresa,
            'email_empresa' => $this->email_empresa,
            'outras_informacoes' => $this->outras_informacoes,
            'envio_material_tecnico' => $this->envio_material_tecnico,
            'minuta_edital' => $this->minuta_edital,
            'abertura_certame' => $this->abertura_certame,
            'homologacao' => $this->homologacao,
            'fonte_recurso' => $this->fonte_recurso,
        ];
    }
}
