<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = [
        'empresa_id', 
        'nome', 
        'email', 
        'telefone',
        'cpf',
        'especialidade'
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }
}
