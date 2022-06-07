<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Garantia extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this->id,
            'contrato_id' => $this->contrato_id,
            'instituicao_financeira' => $this->instituicao_financeira,
            'numero_documento' => $this->numero_documento,
            'valor_garantia' => $this->valor_garantia, 
            'data_validade_garantia' => $this->data_validade_garantia,
        ];
    }
}
