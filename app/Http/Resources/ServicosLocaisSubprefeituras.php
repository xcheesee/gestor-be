<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServicosLocaisSubprefeituras extends JsonResource
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
            'servico_local_id'=> $this->servico_local_id,
            'subprefeitura_id'=> $this->subprefeitura_id,
            'subprefeitura' => new Subprefeitura($this->subprefeitura),
        ];
    }
}
