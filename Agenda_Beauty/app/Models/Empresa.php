<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Empresa extends Authenticatable
{
    use Notifiable;

    protected $table = 'empresas';

    protected $fillable = [
        'nome',
        'cnpj',
        'email',
        'telefone',
        'cep',
        'cidade',
        'bairro',
        'complemento',
        'senha',
    ];

    protected $hidden = [
        'senha',
    ];

    public function getAuthPassword()
    {
        return $this->senha;
    }
}
