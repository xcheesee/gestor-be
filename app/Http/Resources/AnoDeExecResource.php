<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnoDeExecResource extends JsonResource
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
            'ano' => $this->id,
            'id_contrato' => $this->id_contrato,
            'planejado' => $this->planejado,
            'reservado' => $this->reservado,
            'contratado' => $this->contratado
        ];
    }
}
