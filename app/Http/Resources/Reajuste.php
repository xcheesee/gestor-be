<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Reajuste extends JsonResource
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
            'indice_reajuste' => $this->indice_reajuste,
            'valor_reajuste' => $this->valor_reajuste,
            'percentual' => $this->percentual,
            'data_reajuste' => $this->data_reajuste,
        ];
    }
}
