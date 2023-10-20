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
            'tipo_aditamento' => $this->tipo_aditamento,
            'valor_aditamento' => $this->valor_aditamento,
            'percentual' => $this->percentual,
            'data_aditamento' => $this->data_aditamento,
        ];
    }
}
