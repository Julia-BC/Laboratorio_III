<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('esqueceuSenha'); // seu Blade para pedir email
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Procura usuário cliente
        $user = Cliente::where('email', $request->email)->first();

        // Se não achar, procura empresa
        if (!$user) {
            $user = Empresa::where('email', $request->email)->first();
        }

        if (!$user) {
            return back()->withErrors(['email' => 'Nenhum usuário encontrado com esse email.']);
        }

        // Gerar token e salvar no usuário
        $token = Str::random(60);
        $user->password_reset_token = $token;
        $user->password_reset_sent_at = now();
        $user->save();

        // Enviar email (exemplo simples)
        Mail::send('emails.password_reset', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Recuperação de senha - Agenda Beauty');
        });

        return back()->with('status', 'Link de recuperação enviado para seu e-mail!');
    }
}
