<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function showResetForm($token)
    {
        return view('auth.resetar_senha', ['token' => $token]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);

        // Procura usuário pelo token
        $user = Cliente::where('password_reset_token', $request->token)->first();
        if (!$user) {
            $user = Empresa::where('password_reset_token', $request->token)->first();
        }

        if (!$user) {
            return redirect()->route('password.request')->withErrors(['token' => 'Token inválido ou expirado.']);
        }

        // Atualiza senha
        $user->password = Hash::make($request->password);
        $user->password_reset_token = null;
        $user->password_reset_sent_at = null;
        $user->save();

        return redirect()->route('login')->with('success', 'Senha atualizada! Faça login.');
    }
}
