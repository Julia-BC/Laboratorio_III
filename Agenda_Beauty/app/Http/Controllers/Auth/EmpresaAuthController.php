<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Empresa;
use App\Traits\VerifiesEmail; // Importa o trait para verificação de e-mail

class EmpresaAuthController extends Controller
{
    use VerifiesEmail; // Usa o trait para verificação de e-mail

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
            'senhaEmpresa' => 'required|string|min:6|confirmed',
        ], [
            // Mensagens de erro personalizadas
            'nomeEmpresa.required' => 'O nome da empresa é obrigatório.',
            'cnpj.required' => 'O CNPJ é obrigatório.',
            'emailEmpresa.required' => 'O e-mail da empresa é obrigatório.',
            'telefoneEmpresa.required' => 'O telefone da empresa é obrigatório.',
            'cepEmpresa.required' => 'O CEP da empresa é obrigatório.',
            'cidadeEmpresa.required' => 'A cidade da empresa é obrigatória.',
            'bairroEmpresa.required' => 'O bairro da empresa é obrigatório.',
            'senhaEmpresa.required' => 'A senha é obrigatória.',
            'senhaEmpresa.confirmed' => 'As senhas não conferem.',
            'cnpj.unique' => 'Este CNPJ já está cadastrado.',
            'emailEmpresa.unique' => 'Este e-mail já está cadastrado.',
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
        
        $this->sendVerificationEmail($empresa); // Envia o e-mail de verificação

        return redirect()->route('login')->with('success', 'Cadastro empresa realizado! Faça login.');
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
        $empresa = Auth::guard('empresa')->user();
        if (is_null($empresa->email_verified_at)) {
            Auth::guard('empresa')->logout();
            return back()->withErrors(['emailEmpresa' => 'Você precisa verificar seu e-mail antes de acessar o sistema.']);
        }
        return redirect()->route('homeEmpresa')->with('success', 'Login empresa realizado!');
    }

    return back()->withErrors(['emailEmpresa' => 'Credenciais inválidas para empresa.']);
}

    public function index()
    {
        $empresa = Auth::guard('empresa')->user();
        return view('homeEmpresa', compact('empresa')); // Retorna a view do dashboard da empresa com os dados da empresa autenticada
    }

    public function showConta()
    {
        $empresa = Auth::guard('empresa')->user(); // Obtém a empresa autenticada
        return view('gerenciarContaEmpresa', compact('empresa')); // Exibe a conta da empresa
    }

    // Atualiza os dados da conta da empresa
    public function atualizarConta(Request $request)
    {
        $empresa = Auth::guard('empresa')->user(); // Obtém a empresa autenticada

        // Validação dos dados enviados
        $request->validate([
            'nomeEmpresa' => 'required|string|max:255',
            'telefoneEmpresa' => 'required|string|max:20',
            'cepEmpresa' => 'required|string|max:20',
            'cidadeEmpresa' => 'required|string|max:100',
            'bairroEmpresa' => 'required|string|max:100',
            'complementoEmpresa' => 'nullable|string|max:255',
        ]);

        // Atualizar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil')->store('fotos_perfil', 'public');
            $empresa->foto_perfil = $foto;
        }

        // Atualiza os dados da empresa
        $empresa->update([
            'nome' => $request->nomeEmpresa,
            'telefone' => $request->telefoneEmpresa,
            'cep' => $request->cepEmpresa,
            'cidade' => $request->cidadeEmpresa,
            'bairro' => $request->bairroEmpresa,
            'complemento' => $request->complementoEmpresa,
        ]);

        $empresa->save(); // Salva as alterações no banco de dados

        return redirect()->route('empresa.conta')->with('success', 'Conta da empresa atualizada com sucesso!');
    }

    // Exclui a conta da empresa
    public function excluirConta(Request $request)
    {
        \Log::info('Tentativa de excluisão de conta da empresa', ['request_method' =>$request->method() , 'user_id' => Auth::guard('empresa')->id()]);

        $empresa = Auth::guard('empresa')->user(); // Obtém a empresa autenticada

        $request->validate([
            'senha_atual' => 'required|string',
        ]);

        if (!Hash::check($request->senha_atual, $empresa->senha)) {
            return back()->withErrors(['senha_atual' => 'Senha atual incorreta.']);
        }

         // Deletar a foto de perfil, se existir
        if ($empresa->foto_perfil) {
            \Storage::disk('public')->delete($empresa->foto_perfil);
        }

        // Deletar a empresa
        $empresa->delete();

    }

    // Realiza o logout da empresa
    public function logout()
    {
        Auth::guard('empresa')->logout(); // Encerra a sessão da empresa
        return redirect()->route('login')->with('success', 'Logout empresa realizado!');
    }
}
