<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmpenhoNota extends JsonResource
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
            'tipo_empenho' => $this->tipo_empenho,
            'data_emissao' => $this->data_emissao,
            'numero_nota' => $this->numero_nota,
            'valor_empenho' => $this->valor_empenho,
        ];
    }
}
