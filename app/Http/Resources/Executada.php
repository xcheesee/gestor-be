<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Executada extends JsonResource
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
            'mes' => $this->mes,
            'ano' => $this->ano,
            'data_emissao_executado' => $this->data_emissao_executado,
            'numero_executado' => $this->numero_executado,
            'valor_executado' => $this->valor_executado,
        ];
    }
}
