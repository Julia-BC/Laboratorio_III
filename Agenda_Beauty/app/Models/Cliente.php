<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

//permite autenticação de usuário que já está configurado com guard 'cli'
class Cliente extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    //Usa a tabela 'clientes' no banco de dados
    protected $table = 'clientes';

    protected $fillable = [
        'nome',
        'cpf',
        'email',
        'telefone',
        'senha',
    ];

    // Evita que o campo senha apareça quando o modelo é convertido para array ou JSON
    protected $hidden = [
        'senha',
    ];

    // use o campo 'senha' em vez de 'password'
    public function getAuthPassword()
    {
        return $this->senha;
    }
}