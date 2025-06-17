<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    protected $fillable = [
        'cliente_id',
        'servico_id',
        'funcionario_id',
        'data_hora',
        'status',
    ];
}
