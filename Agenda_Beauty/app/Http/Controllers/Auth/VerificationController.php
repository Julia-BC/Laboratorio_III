<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Http\Request;

//Responsável pela verificação de e-mail após o registro via token enviado por e-mail.
class VerificationController extends Controller
{

    /**
     * Verifica o token de confirmação enviado por e-mail.
     * Marca o e-mail como verificado e redireciona o usuário.
     */
    public function verify($token)
    {
        // Buscar por token na tabela clientes
        $user = Cliente::where('verification_token', $token)->first();

        // Se não for cliente, tenta encontrar uma empresa com o token
        if (!$user) {
            $user = Empresa::where('verification_token', $token)->first();
        }

        // Se não encontrou em nenhum dos dois, redireciona com erro
        if (!$user) {
            return redirect('/')->with('error', 'Token inválido.');
        }

        // Marca o e-mail como verificado e remove o token
        $user->email_verified_at = now();
        $user->verification_token = null;
        $user->save();

        // Redireciona para a rota de login com mensagem de sucesso
        if ($user instanceof Cliente) {
            return redirect()->route('cliente.login.form')->with('success', 'E-mail confirmado! Faça login.');
        } else {
            return redirect()->route('empresa.login')->with('success', 'E-mail confirmado! Faça login.');
        }
    }
};


/*
O que esse arquivo faz:
Procura o token na tabela de clientes.
Se não encontrar, procura na tabela de empresas.
Se não encontrar em nenhum, redireciona para a home com erro.
Se encontrar, marca o e-mail como verificado e limpa o token.
Redireciona para a rota de login com mensagem de sucesso.
*/

