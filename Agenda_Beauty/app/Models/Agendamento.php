<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'cliente_id',
        'servico_id',
        'funcionario_id',
        'empresa_id',
        'data_hora',
        'status',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function funcionario()
    {
        return $this->belongsTo(Funcionario::class);
    }

    public function servico()
    {
        return $this->belongsTo(Servicos::class);
    }

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}

