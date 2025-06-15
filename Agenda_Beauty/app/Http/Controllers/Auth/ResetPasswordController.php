<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; 
use function PHPUnit\Framework\returnArgument;// Adicione esta linha


//responsável por exibir o formulário e processar a redefinição de senha
class ResetPasswordController extends Controller
{
    //Exibe o formulário de redefinição de senha
    public function showResetForm(Request $request, $token = null)
    {
        return view('novaSenha')->with([
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    //Processa a redefinição de senha
    public function reset(Request $request)
    {
        // Valida os dados do formulário
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);


        // Procura usuário pelo token
        $user = Cliente::where('password_reset_token', $request->token)->first();

        // Se não encontrar um cliente, tenta encontrar uma empresa
        if (!$user) {
            $user = Empresa::where('password_reset_token', $request->token)->first();
        }

        // Se não encontrou o token em nenhum dos dois, redireciona com erro
        if (!$user) {
            return redirect()->route('password.request')->withErrors(['token' => 'Token inválido ou expirado.']);
        }

        // Atualiza senha e romeve o token
        $user->senha = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_sent_at = null;
        $user->save();

        // Redireciona para o login correspondente com mensagem de sucesso
        if ($user instanceof Cliente) {
            return redirect()->route('login')->with('success', 'Senha atualizada! Faça login.');
        } elseif ($user instanceof Empresa) {
            return redirect()->route('login')->with('success', 'Senha atualizada! Faça login.');
        }

        // Segurança: fallback caso não seja cliente nem empresa
        return redirect()->route('password.request')->withErrors(['token' => 'Erro inesperado.']);
    }


}
