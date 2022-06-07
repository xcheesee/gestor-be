<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RecursoOrcamentario extends JsonResource
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
            'contrato_id' => $this->contrato_id,
            'nota_empenho' => $this->nota_empenho,
            'saldo_empenho' => $this->saldo_empenho,
            'dotacao_orcamentaria' => $this->dotacao_orcamentaria,
        ];
    }
}
