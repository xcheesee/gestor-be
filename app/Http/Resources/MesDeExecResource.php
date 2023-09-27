<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MesDeExecResource extends JsonResource
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
            'id_ano_execucao' => $this->id_ano_execucao,
            'mes' => $this->mes,
            'execucao' => $this->execucao,
        ];
    }
}
