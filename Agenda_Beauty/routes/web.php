<?php

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
Route::get('/login', fn() => redirect()->route('cliente.login.form'))->name('login');
Route::get('/cadastro', fn() => redirect()->route('cliente.register.form'))->name('cadastro');


//ROTAS CLIENTE
Route::prefix('cliente')->group(function () {

    // Login
    Route::get('/login', [ClienteAuthController::class, 'showLoginForm'])->name('cliente.login.form'); //formulário de login
    Route::post('/login', [ClienteAuthController::class, 'login'])->name('cliente.login.submit'); //submissão do login
    
    // Cadastro
    Route::get('/register', [ClienteAuthController::class, 'showRegisterForm'])->name('cliente.register.form'); //formulário de cadastro
    Route::post('/register', [ClienteAuthController::class, 'register'])->name('cliente.register.submit'); //submissão do cadastro
    
    //Dashboard (autenticado) -> Rotas protegidas = apenas clientes autenticados podem acessar
    Route::middleware('auth:cliente')->group(function () {

        Route::get('/dashboard', [ClienteAuthController::class, 'index'])->name('homeCliente'); // Dashboard do cliente
        Route::get('/minha-conta', [ClienteAuthController::class, 'showConta'])->name('cliente.conta'); // Exibe a conta do cliente
        Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout'); // Logout do cliente

        
    });

    // Verificação de e-mail -> rotas que exigem cliente autenticado e link assinado
    Route::middleware(['auth:cliente', 'signed'])->group(function () {
    
    });
    

});

//ROTAS EMPRESA
Route::prefix('empresa')->group(function () {

    // Login 
    Route::get('/login', [EmpresaAuthController::class, 'showLoginForm'])->name('empresa.login'); // Formulário de login
    Route::post('/login', [EmpresaAuthController::class, 'login'])->name('empresa.login.submit'); // Submissão do login

    // Cadastro 
    Route::get('/register', [EmpresaAuthController::class, 'showRegisterForm'])->name('empresa.register'); // Formulário de cadastro
    Route::post('/register', [EmpresaAuthController::class, 'register'])->name('empresa.register.submit'); //

    // Dashboard empresa (autenticado) -> Rotas protegidas = apenas empresas autenticadas podem acessar
    Route::middleware('auth:empresa')->group(function () {

        Route::get('/dashboard', [EmpresaAuthController::class, 'index'])->name('empresa.dashboard'); // Dashboard da empresa
        Route::post('/logout', [EmpresaAuthController::class, 'logout'])->name('empresa.logout'); // Logout da empresa
    });

    // Verificação de e-mail

    Route::middleware(['auth:empresa', 'signed'])->group(function () {
        Route::get('/empresa/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('empresa.verification.verify');
        Route::post('/empresa/email/verification-notification', [VerificationController::class, 'resend'])->name('empresa.verification.send');
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

