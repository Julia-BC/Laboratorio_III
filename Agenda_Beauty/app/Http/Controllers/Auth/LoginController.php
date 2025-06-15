<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cliente;
use App\Models\Empresa;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function ShowLoginForm()
    {
        return view('login'); // Retorna a view de login
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|string',
        ]);

        $email = $request->email;
        $senha = $request->senha;

        // Verifica se o e-mail pertence a um cliente
        if ($cliente = Cliente::where('email', $email)->first()) {
            if (Auth::guard('cliente')->attempt(['email' => $email, 'senha' => $senha])) {
                if (is_null($cliente->email_verified_at)) {
                    Auth::guard('cliente')->logout();
                    return back()->withErrors(['email' => 'Você precisa verificar seu e-mail.']);
                }

                return redirect()->route('homeCliente')->with('success', 'Login como cliente realizado!');
            }
        }

        // Verifica se o e-mail pertence a uma empresa
        // Tenta logar como empresa
        if ($empresa = Empresa::where('email', $email)->first()) {
            if (Hash::check($senha, $empresa->senha)) {
                if (is_null($empresa->email_verified_at)) {
                return back()->withErrors(['email' => 'Você precisa verificar seu e-mail.']);
            }

            Auth::guard('empresa')->login($empresa);
            return redirect()->route('homeEmpresa')->with('success', 'Login como empresa realizado!');
        }
            return back()->withErrors(['email' => 'Senha incorreta para empresa.']);
        }

        return back()->withErrors(['email' => 'Credenciais inválidas.']);
    }

    public function logout(Request $request)
    {
        Auth::guard('cliente')->logout();
        Auth::guard('empresa')->logout();

        return redirect('/login')->with('success', 'Logout realizado com sucesso!');
    }
}
