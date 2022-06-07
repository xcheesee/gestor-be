<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Aditamento extends JsonResource
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
            'data_fim_vigencia_atualizada' => $this->data_fim_vigencia_atualizada,
            'indice_reajuste' => $this->indice_reajuste,
            'data_base_reajuste' => $this->data_base_reajuste,
            'valor_reajustado' => $this->valor_reajustado,
        ];
    }
}
