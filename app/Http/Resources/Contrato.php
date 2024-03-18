<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contrato extends JsonResource
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
            'departamento_id' => $this->departamento_id,
            'departamento' => $this->departamento ? $this->departamento->nome : null,
            'empresa_id' => $this->empresa_id,
            'empresa' => $this->empresa ? $this->empresa->nome : null,
            'empresa_cnpj' => $this->empresa ? $this->empresa->cnpj : null,
            'empresa_telefone' => $this->empresa ? $this->empresa->telefone : null,
            'empresa_email' => $this->empresa ? $this->empresa->email : null,
            'licitacao_modelo_id' => $this->licitacao_modelo_id,
            'licitacao_modelo' => $this->licitacao_modelo ? $this->licitacao_modelo->nome : null,
            'estado_id' => $this->estado_id,
            'estado' => $this->estado ? $this->estado->valor : null,
            'envio_material_tecnico' => $this->envio_material_tecnico,
            'minuta_edital' => $this->minuta_edital,
            'abertura_certame' => $this->abertura_certame,
            'homologacao' => $this->homologacao,
            'processo_sei' => $this->processo_sei,
            'credor' => $this->credor,
            'cnpj_cpf' => $this->cnpj_cpf,
            'tipo_objeto' => $this->tipo_objeto,
            'categoria_id' => $this->categoria_id,
            'categoria' => $this->categoria ? $this->categoria->nome : null,
            'subcategoria' => $this->subcategoria ? $this->subcategoria->nome : null,
            'subcategoria_id' => $this->subcategoria_id,
            'objeto' => $this->objeto,
            'numero_contrato' => $this->numero_contrato,
            'data_assinatura' => $this->data_assinatura,
            'valor_contrato' => $this->valor_contrato,
            'valor_mensal_estimativo' => $this->valor_mensal_estimativo,
            'data_inicio_vigencia' => $this->data_inicio_vigencia,
            'data_vencimento' => $this->data_vencimento,
            'data_vencimento_aditada' => $this->data_vencimento_aditada ? $this->data_vencimento_aditada : null,
            'condicao_pagamento' => $this->condicao_pagamento,
            'prazo_a_partir_de' => $this->prazo_a_partir_de,
            'data_prazo_maximo' => $this->data_prazo_maximo,
            'numero_nota_reserva' => $this->numero_nota_reserva,
            'valor_reserva' => $this->valor_reserva,
            'nome_empresa' => $this->nome_empresa,
            'telefone_empresa' => $this->telefone_empresa,
            'email_empresa' => $this->email_empresa,
            'outras_informacoes' => $this->outras_informacoes,
            'execucao_financeira' => $this->execucao_financeira,
            'dias_vigente' => $this->dias_vigente,
            'diferenca_envio_minuta' => $this->diferenca_envio_minuta ? $this->diferenca_envio_minuta['days'] : null,
            'diferenca_envio_vencimento' => $this->diferenca_envio_vencimento ? $this->diferenca_envio_vencimento['days'] : null,
            'diferenca_minuta_abertura' => $this->diferenca_minuta_abertura ? $this->diferenca_minuta_abertura['days'] : null,
            'diferenca_abertura_homologacao' => $this->diferenca_abertura_homologacao ? $this->diferenca_abertura_homologacao['days'] : null,
            'diferenca_homologacao_vencimento' => $this->diferenca_homologacao_vencimento ? $this->diferenca_homologacao_vencimento['days'] : null,
            'diferenca_homologacao_vigencia' => $this->diferenca_homologacao_vigencia ? $this->diferenca_homologacao_vigencia['days'] : null,
            'diferenca_vigencia_vencimento' => $this->diferenca_vigencia_vencimento ? $this->diferenca_vigencia_vencimento['days'] : null,
            'adt_valor_corrigido' => $this->adt_valor_corrigido ? $this->adt_valor_corrigido : null,
        ];
    }
}
