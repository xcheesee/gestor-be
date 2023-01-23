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
            'numero_dotacao' => $this->dotacao_tipo ? $this->dotacao_tipo->numero_dotacao : null,
            'descricao' => $this->dotacao_tipo ? $this->dotacao_tipo->descricao : null,
            'tipo_despesa' => $this->dotacao_tipo ? $this->dotacao_tipo->tipo_despesa : null,
            'contrato_id' => $this->contrato_id,
            'recursos' => DotacaoRecurso::collection($this->dotacao_recursos),
        ];
    }
}
