<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Distrito extends JsonResource
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
            'subprefeitura_id' => $this->subprefeitura_id,
            'nome' => $this->nome,
        ];
    }
}
