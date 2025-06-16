<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Servicos extends Model
{
    protected $table = 'servicos';

    protected $fillable = [
        'nome',
        'descricao',
        'preco',
        'duracao',
    ];

    // Definindo a relação com a tabela de agendamentos
    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class);
    }
}
