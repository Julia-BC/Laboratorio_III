<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Cliente;
use App\Models\Agendamento;
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
        //Recebe os dados
        $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|unique:clientes,cpf',
            'email' => 'required|string|email|max:255|unique:clientes,email',
            'telefone' => 'required|string|max:20',
            'senha' => 'required|string|min:6|confirmed',
        ], [ 
            // mensagens de erro personalizadas = validação
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
            $Cliente = Auth::guard('cliente')->user();

            if (!$Cliente->email_verified_at) {
            Auth::guard('cliente')->logout();
            return back()->withErrors(['email' => 'Você precisa confirmar seu e-mail antes de acessar.']);
        }

            return redirect()->route('homeCliente')->with('success', 'Login cliente realizado!');
        }

        // se falhar, retorna com erro
        return back()->withErrors(['email' => 'Credenciais inválidas para cliente.']);
    }


    public function index()
{
    $Cliente = Auth::guard('cliente') -> user();
    return view('homeCliente', compact('Cliente')); // retorna a view do dashboard do cliente com os dados do cliente autenticado
}

    public function showConta()
    {
        $Cliente = Auth::guard('cliente')->user(); // obtém o cliente autenticado
        return view('gerenciarContaCliente', compact('Cliente')); // retorna a view da conta do cliente com os dados do cliente autenticado
    }

    public function uploadFoto(Request $request)
{
    $request->validate([
        'foto' => 'required|image|max:2048', // 2MB máx
    ]);

    $cliente = auth()->user(); // ou Cliente::find($id)

    // Salva a imagem
    $caminho = $request->file('foto')->store('fotos', 'public');

    // Atualiza o caminho no banco
    $cliente->foto_perfil = $caminho;
    $cliente->save();

    return back()->with('success', 'Foto atualizada!');
}

    // atualiza os dados do cliente
    public function atualizarConta(Request $request)
    {
        $cliente = Auth::guard('cliente')->user();

        $request->validate([
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'telefone' => 'required|string|max:20',
            'foto_perfil' => 'nullable|image|max:2048',
            'senha_atual' => 'nullable|string',
            'nova_senha' => 'nullable|string|min:6|confirmed',
        ], [
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Este e-mail já está cadastrado.',
            'telefone.required' => 'O telefone é obrigatório.',
            'nova_senha.min' => 'A nova senha deve ter pelo menos 6 caracteres.',
            'nova_senha.confirmed' => 'As senhas não conferem.',
        ]);

        // Atualizar foto de perfil
        if ($request->hasFile('foto_perfil')) {
            $foto = $request->file('foto_perfil')->store('fotos_perfil', 'public');
            $cliente->foto_perfil = $foto;
        }

        // Atualizar e-mail e telefone
        $cliente->email = $request->email;
        $cliente->telefone = $request->telefone;

        // Atualizar senha, se fornecida
        if ($request->filled('senha_atual') && $request->filled('nova_senha')) {
            if (!Hash::check($request->senha_atual, $cliente->senha)) {
                return back()->withErrors(['senha_atual' => 'Senha atual incorreta.']);
            }
            $cliente->senha = Hash::make($request->nova_senha);
        }

        $cliente->save();

        return redirect()->back()->with('success', 'Conta atualizada com sucesso!');
    }

    public function excluirConta(Request $request)
    {
        \Log::info('Tentativa de exclusão de conta do cliente', ['request_method' => $request->method() , 'user_id' => Auth::guard('cliente')->id()]);

        $cliente = Auth::guard('cliente')->user();

        // Opcional: Validar senha atual para maior segurança
        $request->validate([
            'senha_atual' => 'required|string',
        ]);

        if (!Hash::check($request->senha_atual, $cliente->senha)) {
            return back()->withErrors(['senha_atual' => 'Senha atual incorreta.']);
        }

        // Deletar a foto de perfil, se existir
        if ($cliente->foto_perfil) {
            \Storage::disk('public')->delete($cliente->foto_perfil);
        }

        // Deletar o cliente
        $cliente->delete();

        // Fazer logout
        Auth::guard('cliente')->logout();

        return redirect()->route('login')->with('success', 'Conta excluída com sucesso!');
    }

    public function mostrarAtendimentos()
{
    $clienteId = auth()->id(); // ou auth('cliente')->id(); se tiver guard específico

    $agendamentos = Agendamento::with(['cliente', 'empresa', 'funcionario', 'servico'])
        ->where('cliente_id', $clienteId)
        ->get();

    return view('atendimentosClientes', compact('agendamentos'));
}



    // realiza o logout do cliente
    public function logout()
    {
    Auth::guard('cliente')->logout(); // encerra a sessão do cliente
    return redirect()->route('login')->with('success', 'Logout cliente realizado!');
    }

    
}