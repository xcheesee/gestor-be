<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Contrato extends Model
{
    protected $fillable = [
        'departamento_id',
        'empresa_id',
        'licitacao_modelo_id',
        'categoria_id',
        'subcategoria_id',
        'estado_id',
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
        'data_recebimento_definitivo',
        'data_recebimento_provisorio',
        'termo_recebimento_definitivo',
        'termo_recebimento_provisorio'
    ];

    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function licitacao_modelo()
    {
        return $this->belongsTo(LicitacaoModelo::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
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

    //Aqui vamos usar sempre a data de vencimento com os aditamentos para pegar contratos prestes a vencer
    public function getDiferencaAteVencimentoAttribute()
    {
        $date1 = date_create_from_format('Y-m-d', $this->data_vencimento_aditada);
        $date2 = date_create_from_format('Y-m-d', date('Y-m-d'));
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiasAteVencimentoAttribute()
    {
        return $this->diferenca_ate_vencimento['days'];
    }

    public function getMesesAteVencimentoAttribute()
    {
        $texto = '';
        if ($this->diferenca_ate_vencimento['m'] > 0) {
            $texto = $this->diferenca_ate_vencimento['m'] == 1 ? $this->diferenca_ate_vencimento['m'] . ' mês' : $this->diferenca_ate_vencimento['m'] . ' meses';
            if ($this->diferenca_ate_vencimento['d'] > 0)
                $texto .= ' e ' . $this->diferenca_ate_vencimento['d'] . ' dia(s)';
        } else {
            if ($this->diferenca_ate_vencimento['d'] > 0)
                $texto = $this->diferenca_ate_vencimento['d'] . ' dia(s)';
            else
                $texto = 'Vencido há ' . ($this->diferenca_ate_vencimento['d'] * -1) . ' dia(s)';
        }
        return $texto;
    }

    public function getDiferencaEnvioMinutaAttribute()
    {
        if (!$this->envio_material_tecnico or !$this->minuta_edital) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->envio_material_tecnico);
        $date2 = date_create_from_format('Y-m-d', $this->minuta_edital);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaEnvioVencimentoAttribute()
    {
        if (!$this->envio_material_tecnico or !$this->data_vencimento) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->envio_material_tecnico);
        $date2 = date_create_from_format('Y-m-d', $this->data_vencimento);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaMinutaAberturaAttribute()
    {
        if (!$this->minuta_edital or !$this->abertura_certame) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->minuta_edital);
        $date2 = date_create_from_format('Y-m-d', $this->abertura_certame);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaAberturaHomologacaoAttribute()
    {
        if (!$this->homologacao or !$this->abertura_certame) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->abertura_certame);
        $date2 = date_create_from_format('Y-m-d', $this->homologacao);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaHomologacaoVencimentoAttribute()
    {
        if (!$this->homologacao or !$this->data_vencimento) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->homologacao);
        $date2 = date_create_from_format('Y-m-d', $this->data_vencimento);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaHomologacaoVigenciaAttribute()
    {
        if (!$this->homologacao or !$this->data_inicio_vigencia) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->homologacao);
        $date2 = date_create_from_format('Y-m-d', $this->data_inicio_vigencia);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaVigenciaVencimentoAttribute()
    {
        if (!$this->data_vencimento or !$this->data_inicio_vigencia) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->data_inicio_vigencia);
        $date2 = date_create_from_format('Y-m-d', $this->data_vencimento);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }

    public function getDiferencaVencimentoPrazoMaximoAttribute()
    {
        if (!$this->data_vencimento or !$this->data_prazo_maximo) {
            return null;
        }
        $date1 = date_create_from_format('Y-m-d', $this->data_prazo_maximo);
        $date2 = date_create_from_format('Y-m-d', $this->data_vencimento);
        $diff = (array) date_diff($date1, $date2);
        return $diff;
    }
}
