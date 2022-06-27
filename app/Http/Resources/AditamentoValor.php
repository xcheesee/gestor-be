<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AditamentoValor extends JsonResource
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
            'tipo_aditamentos' => $this->tipo_aditamentos,
            'valor_aditamento' => $this->valor_aditamento,
            'dias_reajuste' => $this->dias_reajuste,
            'indice_reajuste' => $this->indice_reajuste,
            'pct_reajuste' => $this->pct_reajuste,
        ];
    }
}
