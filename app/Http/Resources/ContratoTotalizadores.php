<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContratoTotalizadores extends JsonResource
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
            'valor_contrato' => $this->valor_contrato,
            'valor_reserva' => $this->valor_reserva,
            'valor_dotacoes' => $this->valor_dotacoes,
            'valor_empenhos' => $this->valor_empenhos,
            'valor_planejados' => $this->valor_planejados,
            'valor_aditamentos' => $this->valor_aditamentos,
        ];
    }
}
