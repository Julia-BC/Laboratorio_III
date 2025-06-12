<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function verify($token)
    {
        // Buscar por token na tabela clientes e empresas
        $user = Cliente::where('verification_token', $token)->first();

        if (!$user) {
            $user = Empresa::where('verification_token', $token)->first();
        }

        if (!$user) {
            return redirect('/')->with('error', 'Token inválido.');
        }

        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        if ($user instanceof Cliente) {
            return redirect()->route('cliente.login.form')->with('success', 'E-mail confirmado! Faça login.');
        } else {
            return redirect()->route('empresa.login')->with('success', 'E-mail confirmado! Faça login.');
        }
    }
};


/*
Procura o token na tabela de clientes.
Se não encontrar, procura na tabela de empresas.
Se não encontrar em nenhum, redireciona para a home com erro.
Se encontrar, marca o e-mail como verificado e limpa o token.
Redireciona para a rota de login com mensagem de sucesso.
*/

