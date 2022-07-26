<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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

    public function scopeInicioDepoisDe(Builder $query, $date): Builder
    {
        return $query->where('data_inicio_vigencia', '>=', Carbon::parse($date));
    }

    public function scopeInicioAntesDe(Builder $query, $date): Builder
    {
        return $query->where('data_inicio_vigencia', '<=', Carbon::parse($date));
    }

    public function scopeVencimentoDepoisDe(Builder $query, $date): Builder
    {
        return $query->where('data_vencimento', '>=', Carbon::parse($date));
    }

    public function scopeVencimentoAntesDe(Builder $query, $date): Builder
    {
        return $query->where('data_vencimento', '<=', Carbon::parse($date));
    }

    public function getDiferencaAteVencimentoAttribute(){
        $date1 = date_create_from_format('Y-m-d', $this->data_vencimento);
        $date2 = date_create_from_format('Y-m-d', date('Y-m-d'));
        $diff = (array) date_diff($date1,$date2);
        return $diff;
    }

    public function getDiasAteVencimentoAttribute(){
        return $this->diferenca_ate_vencimento['days'];
    }

    public function getMesesAteVencimentoAttribute(){
        $texto = '';
        if ($this->diferenca_ate_vencimento['m'] > 0){
            $texto = $this->diferenca_ate_vencimento['m'] == 1 ? $this->diferenca_ate_vencimento['m'].' mês' : $this->diferenca_ate_vencimento['m'].' meses';
            if ($this->diferenca_ate_vencimento['d'] > 0) $texto .= ' e '.$this->diferenca_ate_vencimento['d'].' dia(s)';
        }else{
            if ($this->diferenca_ate_vencimento['d'] > 0) $texto = $this->diferenca_ate_vencimento['d'].' dia(s)';
            else $texto = 'Vencido há '.($this->diferenca_ate_vencimento['d']*-1).' dia(s)';
        }
        return $texto;
    }
}
