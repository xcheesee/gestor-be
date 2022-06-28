<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DotacaoTipo extends JsonResource
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
            'numero_dotacao' => $this->numero_dotacao,
            'descricao' => $this->descricao,
            'tipo_despresa' => $this->tipo_despresa,
        ];
    }
}
