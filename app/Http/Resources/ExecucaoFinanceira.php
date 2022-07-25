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
            'planejado_inicial' => $this->planejado_inicial,
            'contratado_inicial' => $this->contratado_inicial,
            'contratado_atualizado' => $this->contratado_atualizado,
            'valor_reajuste' => $this->valor_reajuste,
            'valor_aditivo' => $this->valor_aditivo,
            'valor_cancelamento' => $this->valor_cancelamento,
            'empenhado' => $this->empenhado,
            'executado' => $this->executado,
            'saldo' => $this->saldo,
        ];
    }
}
