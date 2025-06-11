<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Empresa extends Authenticatable implements MustVerifyEmail
{
    use Notifiable; // Trait para notificações, incluindo verificação de e-mail
    
    protected $table = 'empresas'; // Define o nome da tabela associada ao modelo
    
    //Lista de campos que podem ser atribuídos em massa
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
    
    // campos ocultos ao transformar o modelo em array/JSON
    protected $hidden = [
        'senha',
    ];
    
    // define qual campo será usado para autenticação
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
