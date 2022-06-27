<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExecucaoFinanceira extends JsonResource
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
            'planejado_inicial' => $this->valor_executado,
            'contratado_inicial' => $this->valor_executado,
            'valor_reajuste' => $this->valor_executado,
            'valor_aditivo' => $this->valor_executado,
            'valor_cancelamento' => $this->valor_executado,
            'empenhado' => $this->valor_executado,
            'executado' => $this->valor_executado,
        ];
    }
}
