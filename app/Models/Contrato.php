<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'tipo_contratacao_id',
        'processo_sei',
        'dotacao_orcamentaria',
        'credor',
        'cnpj_cpf',
        'tipo_objeto',
        'objeto',
        'numero_contrato',
        'data_assinatura',
        'valor_contrato',
        'valor_mensal_estimativo',
        'data_inicio_vigencia',
        'data_vencimento',
        'condicao_pagamento',
        'prazo_a_partir_de',
        'data_prazo_maximo',
        'nome_empresa',
        'telefone_empresa',
        'email_empresa',
        'outras_informacoes',
        'envio_material_tecnico',
        'minuta_edital',
        'abertura_certame',
        'homologacao',
        'fonte_recurso',
    ];

    public function tipo_contratacao()
    {
        return $this->belongsTo(TipoContratacao::class);
    }
}
