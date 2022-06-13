<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Devolucao extends JsonResource
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
            'ano' => $this->ano,
            'data_devolucao' => $this->data_devolucao,
            'numero_devolucao' => $this->numero_devolucao,
            'valor_devolucao' => $this->valor_devolucao,
        ];
    }
}
