<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'licitacao_modelo_id',
        'envio_material_tecnico',
        'minuta_edital',
        'abertura_certame',
        'homologacao',
        'processo_sei',
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
        'numero_nota_reserva',
        'valor_reserva',
        'nome_empresa',
        'telefone_empresa',
        'email_empresa',
        'outras_informacoes',
    ];

    public function licitacao_modelo()
    {
        return $this->belongsTo(LicitacaoModelo::class);
    }
}
