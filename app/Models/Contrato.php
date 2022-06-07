<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    protected $fillable = [
        'processo_sei',
        'credor',
        'cnpj_cpf',
        'objeto',
        'numero_contrato',
        'data_assinatura',
        'valor_contrato',
        'data_inicio_vigencia',
        'data_fim_vigencia',
        'condicao_pagamento',
        'prazo_contrato_meses',
        'prazo_a_partir_de',
        'data_prazo_maximo',
        'nome_empresa',
        'telefone_empresa',
        'email_empresa',
        'outras_informacoes',
    ];
}
