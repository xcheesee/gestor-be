<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Dotacao extends JsonResource
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
            'dotacao_tipo_id' => $this->dotacao_tipo_id,
            'contrato_id' => $this->contrato_id,
            'valor_dotacao' => $this->valor_dotacao,
        ];
    }
}
