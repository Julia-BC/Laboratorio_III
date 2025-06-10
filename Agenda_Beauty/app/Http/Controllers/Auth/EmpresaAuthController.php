<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;

class EmpresaAuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.empresa-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nomeEmpresa' => 'required|string|max:255',
            'CNPJ' => 'required|string|unique:empresas,CNPJ',
            'emailEmpresa' => 'required|string|email|max:255|unique:empresas,email',
            'telefoneEmpresa' => 'required|string|max:20',
            'cepEmpresa' => 'required|string|max:20',
            'cidadeEmpresa' => 'required|string|max:100',
            'bairroEmpresa' => 'required|string|max:100',
            'complementoEmpresa' => 'nullable|string|max:255',
            'senhaEmpresa' => 'required|string|min:8|confirmed',
        ]);

        Empresa::create([
            'nome' => $request->nomeEmpresa,
            'CNPJ' => $request->CNPJ,
            'email' => $request->emailEmpresa,
            'telefone' => $request->telefoneEmpresa,
            'cep' => $request->cepEmpresa,
            'cidade' => $request->cidadeEmpresa,
            'bairro' => $request->bairroEmpresa,
            'complemento' => $request->complementoEmpresa,
            'senha' => Hash::make($request->senhaEmpresa),
        ]);

        return redirect()->route('empresa.login')->with('success', 'Cadastro empresa realizado! Faça login.');
    }

    public function showLoginForm()
    {
        return view('auth.empresa-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'emailEmpresa' => 'required|string|email',
            'senhaEmpresa' => 'required|string',
        ]);

        if (Auth::guard('empresa')->attempt(['email' => $credentials['emailEmpresa'], 'password' => $credentials['senhaEmpresa']])) {
            return redirect()->route('empresa.dashboard')->with('success', 'Login empresa realizado!');
        }

        return back()->withErrors(['emailEmpresa' => 'Credenciais inválidas para empresa.']);
    }

    public function logout()
    {
        Auth::guard('empresa')->logout();
        return redirect()->route('empresa.login')->with('success', 'Logout empresa realizado!');
    }
}
