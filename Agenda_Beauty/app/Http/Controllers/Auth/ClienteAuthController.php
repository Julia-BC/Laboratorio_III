<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;

class ClienteAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('cadastro');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'CPF' => 'required|string|unique:clientes,CPF',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'senha' => 'required|string|min:8|confirmed',
        ]);

        Cliente::create([
            'nome' => $request->nome,
            'CPF' => $request->CPF,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'senha' => Hash::make($request->senha),
        ]);

        return redirect()->route('cliente.login')->with('success', 'Cadastro cliente realizado! Faça login.');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);

        if (Auth::guard('cliente')->attempt(['email' => $credentials['email'], 'password' => $credentials['senha']])) {
            return redirect()->route('cliente.dashboard')->with('success', 'Login cliente realizado!');
        }

        return back()->withErrors(['email' => 'Credenciais inválidas para cliente.']);
    }

    public function logout()
    {
        Auth::guard('cliente')->logout();
        return redirect()->route('cliente.login')->with('success', 'Logout cliente realizado!');
    }
}
