<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Planejada extends JsonResource
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
            'tipo_lancamento' => $this->tipo_lancamento,
            'modalidade' => $this->modalidade,
            'data_emissao_planejado' => $this->data_emissao_planejado,
            'numero_planejado' => $this->numero_planejado,
            'valor_planejado' => $this->valor_planejado,
        ];
    }
}
