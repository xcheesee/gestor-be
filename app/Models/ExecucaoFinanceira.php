<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExecucaoFinanceira extends Model
{
    use HasFactory;

    protected $table = 'execucao_financeira';

    protected $fillable = [
        'contrato_id',
        'mes',
        'ano',
        'planejado_inicial',
        'contratado_inicial',
        'valor_reajuste',
        'valor_aditivo',
        'valor_cancelamento',
        'empenhado',
        'executado',
    ];

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function getContratadoAtualizadoAttribute(){
        return $this->contratado_inicial + $this->valor_reajuste + $this->valor_aditivo - $this->valor_cancelamento;
    }

    public function getSaldoAttribute(){
        return $this->empenhado - $this->executado;
    }
}
