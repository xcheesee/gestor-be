<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicoLocal extends JsonResource
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
            'regiao' => $this->regiao,
            'contrato_id' => $this->contrato_id,
            'distrito_id' => $this->distrito_id,
            'distrito' => $this->distrito ? $this->distrito->nome : null,
            'subprefeitura_id' => $this->subprefeitura_id,
            'unidade' => $this->unidade,
            'subprefeitura' => $this->subprefeitura ? ServicosLocaisSubprefeituras::collection($this->subprefeitura) : null,
        ];
    }
}
