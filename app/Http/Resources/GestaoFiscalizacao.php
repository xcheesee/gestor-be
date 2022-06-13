<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GestaoFiscalizacao extends JsonResource
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
            'nome_gestor' => $this->nome_gestor,
            'email_gestor' => $this->email_gestor,
            'nome_fiscal' => $this->nome_fiscal,
            'email_fiscal' => $this->email_fiscal,
            'nome_suplente' => $this->nome_suplente,
            'email_suplente' => $this->email_suplente
        ];
    }
}
