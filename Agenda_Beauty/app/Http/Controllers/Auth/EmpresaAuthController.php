<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;

class EmpresaAuthController extends Controller
{
    // Exibe o formulário de cadastro da empresa
    public function showRegisterForm()
    {
        return view('auth.empresa-register'); // resources/views/auth/empresa-register.blade.php
    }

    //processa o cadastro de uma nova empresa
    public function register(Request $request)
    {
        // Validação dos dados enviados
        $request->validate([
            'nomeEmpresa' => 'required|string|max:255',
            'cnpj' => 'required|string|unique:empresas,cnpj',
            'emailEmpresa' => 'required|string|email|max:255|unique:empresas,email',
            'telefoneEmpresa' => 'required|string|max:20',
            'cepEmpresa' => 'required|string|max:20',
            'cidadeEmpresa' => 'required|string|max:100',
            'bairroEmpresa' => 'required|string|max:100',
            'complementoEmpresa' => 'nullable|string|max:255',
            'senhaEmpresa' => 'required|string|min:8|confirmed',
        ]);

        // Criação da empresa no banco de dados
        $empresa = Empresa::create([
            'nome' => $request->nomeEmpresa,
            'cnpj' => $request->cnpj,
            'email' => $request->emailEmpresa,
            'telefone' => $request->telefoneEmpresa,
            'cep' => $request->cepEmpresa,
            'cidade' => $request->cidadeEmpresa,
            'bairro' => $request->bairroEmpresa,
            'complemento' => $request->complementoEmpresa,
            'senha' => Hash::make($request->senhaEmpresa), // Criptografa a senha
        ]);
        // Envia link de verificação por e-mail (assumindo uso de `MustVerifyEmail`)
        $empresa->sendEmailVerificationNotification(); // Envia o e-mail de verificação

        return redirect()->route('empresa.login')->with('success', 'Cadastro empresa realizado! Faça login.');
    }

    // Exibe o formulário de login da empresa
    public function showLoginForm()
    {
        return view('login'); 
    }

    // Processa a autenticação da empresa
    public function login(Request $request)
    {
        // Validação dos dados enviados
        $credentials = $request->validate([
            'emailEmpresa' => 'required|string|email',
            'senhaEmpresa' => 'required|string',
        ]);

        // Tenta autenticar a empresa com o guard 'empresa'
        if (Auth::guard('empresa')->attempt(['email' => $credentials['emailEmpresa'], 'password' => $credentials['senhaEmpresa']])) {
            return redirect()->route('empresa.dashboard')->with('success', 'Login empresa realizado!');
        }

        return back()->withErrors(['emailEmpresa' => 'Credenciais inválidas para empresa.']);
    }

    // Realiza o logout da empresa
    public function logout()
    {
        Auth::guard('empresa')->logout(); // Encerra a sessão da empresa
        return redirect()->route('empresa.login')->with('success', 'Logout empresa realizado!');
    }
}
