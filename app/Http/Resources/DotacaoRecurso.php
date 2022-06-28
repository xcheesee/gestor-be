<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DotacaoRecurso extends JsonResource
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
            'dotacao_id' => $this->dotacao_id,
            'origem_recurso_id' => $this->origem_recurso_id,
            'outros_descricao' => $this->outros_descricao,
        ];
    }
}
