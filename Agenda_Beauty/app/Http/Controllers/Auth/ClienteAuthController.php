<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Traits\VerifiesEmail; // Importa o trait para verificação de e-mail

class ClienteAuthController extends Controller
{
    use VerifiesEmail; // Usa o trait para verificação de e-mail

    //exibe o formulário de cadastro do cliente
    public function showRegisterForm()
    {
        return view('cadastro'); // resources/views/cadastro.blade.php
    }

    //cadastro de um novo cliente
    public function register(Request $request)
    {
        //validação dos dados enviados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:clientes,cpf',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'senha' => 'required|string|min:8|confirmed',
        ], [
            'nome.required' => 'O nome é obrigatório.',
            'cpf.required' => 'O CPF é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'telefone.required' => 'O telefone é obrigatório.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.confirmed' => 'As senhas não conferem.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'email.unique' => 'Este e-mail já está cadastrado.',
        ]);

        //criação do cliente no banco de dados
        $Cliente = Cliente::create([
            'nome' => $request->nome,
            'cpf' => $request->cpf,
            'email' => $request->email,
            'telefone' => $request->telefone,
            'senha' => Hash::make($request->senha), // criptografa a senha
        ]);

        $this->sendVerificationEmail($Cliente); // Envia o e-mail de verificação

        return redirect()->route('login')->with('success', 'Cadastro cliente realizado! Faça login.');
    }

    //exibe o formulário de login do cliente
    public function showLoginForm()
    {
        return view('login'); // resources/views/login.blade.php
    }

    //autenticação do cliente
    public function login(Request $request)
    {
        //validação dos dados enviados
        $credentials = $request->validate([
            'email' => 'required|string|email',
            'senha' => 'required|string',
        ]);

        // tenta autenticar o cliente com o guard 'cliente
        if (Auth::guard('cliente')->attempt(['email' => $credentials['email'], 'password' => $credentials['senha']])) {
            return redirect()->route('cliente.dashboard')->with('success', 'Login cliente realizado!');
        }

        // se falhar, retorna com erro
        return back()->withErrors(['email' => 'Credenciais inválidas para cliente.']);
    }

    // realiza o logout do cliente
    public function logout()
    {
        Auth::guard('cliente')->logout(); // encerra a sessão do cliente
        return redirect()->route('cliente.login.form')->with('success', 'Logout cliente realizado!');
    }
}
