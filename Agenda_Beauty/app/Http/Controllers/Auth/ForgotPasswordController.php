<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;


//Responsáavel por exibir o formulário de recuperação de senha e enviar o link de redefinição
class ForgotPasswordController extends Controller
{

    // Exibe o formulário para solicitar o link de redefinição de senha
    public function showLinkRequestForm()
    {
        return view('esqueceuSenha'); // view para pedir email
    }

    // Processa a solicitação de envio do link de redefinição de senha
    public function sendResetLinkEmail(Request $request)
    {
        //valida se o email foi informado corretamente
        $request->validate(['email' => 'required|email']);

        // Procura usuário cliente
        $user = Cliente::where('email', $request->email)->first();

        // Se não achar, procura empresa
        if (!$user) {
            $user = Empresa::where('email', $request->email)->first();
        }

        // Se não encontrar nenhum usuário, retorna erro
        if (!$user) {
            return back()->withErrors(['email' => 'Nenhum usuário encontrado com esse email.']);
        }

        // Gerar token aleatório e salvar no banco com data de envio
        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->password_reset_sent_at = now();
        $user->save();

        // Envia o e-mail com o link de redefinição (view: emails.password_reset)
        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Recuperação de senha - Agenda Beauty');
        });

        //Retorna com mensagem de sucesso
        return back()->with('status', 'Link de recuperação enviado para seu e-mail!');
    }
}
