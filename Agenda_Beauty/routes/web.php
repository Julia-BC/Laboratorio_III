<?php

use App\Http\Controllers\Auth\AgendamentoController;
use App\Http\Controllers\Auth\FuncionarioController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// Controllers de autenticação
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\Auth\EmpresaAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

//Rota para a página inicial -> Home
Route::get('/', function () {
    return view('home'); // view principal -> resources/views/home.blade.php
});

// Aliases usados na home -> redirecionar para o login e cadastro
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login'); //formulário de login
Route::post('/login', [LoginController::class, 'login'])->name('login.submit'); //submissão do login
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
// Cadastro
Route::get('/cadastro', fn() => redirect()->route('cliente.register.form'))->name('cadastro');



//ROTAS CLIENTE
Route::prefix('cliente')->group(function () {
    
    //CADASTRO
    Route::get('/register', [ClienteAuthController::class, 'showRegisterForm'])->name('cliente.register.form'); //formulário de cadastro
    Route::post('/register', [ClienteAuthController::class, 'register'])->name('cliente.register.submit'); //submissão do cadastro

    //Dashboard (autenticado) -> Rotas protegidas = apenas clientes autenticados podem acessar
    Route::middleware('auth:cliente')->group(function () {

        Route::get('/dashboard', [ClienteAuthController::class, 'index'])->name('homeCliente'); // Dashboard do cliente
        Route::get('/minha-conta', [ClienteAuthController::class, 'showConta'])->name('cliente.conta'); // Exibe a conta do cliente
        Route::post('/cliente/foto', [ClienteAuthController::class, 'uploadFoto'])->name('cliente.uploadFoto');
        Route::post('/minha-conta', [ClienteAuthController::class, 'atualizarConta'])->name('cliente.conta.atualizar'); // Atualiza a conta do cliente
        Route::delete('/minha-conta/excluir', [ClienteAuthController::class, 'excluirConta'])->name('cliente.conta.excluir'); // excluir a conta do cliente
        // Exibe os agendamentos do cliente
        Route::get('/agendamentos', [AgendamentoController::class, 'index'])->name('agendamentos');
        Route::get('/servicos', [AgendamentoController::class, 'index']);
        Route::post('/agendamentos', [AgendamentoController::class, 'store'])->name('agendamentos.store');
    });

    // Verificação de e-mail -> rotas que exigem cliente autenticado e link assinado
    Route::middleware(['auth:cliente', 'signed'])->group(function () {
        
    });
    
    
});

//ROTAS EMPRESA
Route::prefix('empresa')->group(function () {
    
    //Cadastro
    Route::get('/register', [EmpresaAuthController::class, 'showRegisterForm'])->name('empresa.register'); // Formulário de cadastro
    Route::post('/register', [EmpresaAuthController::class, 'register'])->name('empresa.register.submit'); // Submissão do cadastro

    // Dashboard empresa (autenticado) -> Rotas protegidas = apenas empresas autenticadas podem acessar
    Route::middleware('auth:empresa')->group(function () {

        Route::get('/dashboard', [EmpresaAuthController::class, 'index'])->name('homeEmpresa'); // Dashboard da empresa
        Route::get('/minha-conta', [EmpresaAuthController::class, 'showConta'])->name('empresa.conta'); // Exibe a conta do cliente
        Route::post('/minha-conta', [EmpresaAuthController::class, 'atualizarConta'])->name('empresa.conta.atualizar'); // Atualiza a conta do cliente
        Route::delete('/minha-conta/excluir', [EmpresaAuthController::class, 'excluirConta'])->name('empresa.conta.excluir'); // excluir a conta do cliente
    });

    // Verificação de e-mail

    Route::middleware(['auth:empresa', 'signed'])->group(function () {
        Route::get('/empresa/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('empresa.verification.verify');
        Route::post('/empresa/email/verification-notification', [VerificationController::class, 'resend'])->name('empresa.verification.send');
    });


    //ROTAS FUNCIONARIOS
    Route::middleware('auth:empresa')->group(function () {

        Route::get('funcionarios', [FuncionarioController::class, 'index'])->name('funcionario.conta'); // Exibe os funcionário

        // Cadastrar funcionário
        Route::post('funcionarios', [FuncionarioController::class, 'store'])->name('empresa.funcionarios.cadastrar');
        // Editar funcionário (pode ser com modal ou página separada)
        Route::get('funcionarios/{id}/editar', [FuncionarioController::class, 'edit'])->name('empresa.funcionarios.editar');
        
        // Atualizar funcionário (página ou modal de edição)
        Route::put('funcionarios/{id}', [FuncionarioController::class, 'update'])->name('empresa.funcionarios.atualizar');

        // Excluir funcionário
        Route::delete('funcionarios/{id}', [FuncionarioController::class, 'destroy'])->name('empresa.funcionarios.excluir');
    });

});



// VERIFICAÇÃO DE E-MAIL personalizada (para ambos)
Route::get('/verify-email/{token}', [VerificationController::class, 'verify'])->name('verify.email');


// RECUPERAÇÃO DE SENHA – formulário, envio de link e redefinição

//1.Exibir formulário para digitar email
Route::get('/esqueci-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
//2.Enviar link por email
Route::post('/esqueci-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
//3.Exibir formulário para nova senha com token e email
Route::get('/resetar-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
//4.Envio da nova senha
Route::post('/resetar-senha', [ResetPasswordController::class, 'reset'])->name('password.update');