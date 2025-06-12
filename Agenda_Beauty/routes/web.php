<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\Auth\EmpresaAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

//Rota para a página inicial -> Home
Route::get('/', function () {
    return view('home'); // resources/views/home.blade.php
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

    // Verificação de e-mail
    Route::middleware(['auth:cliente', 'signed'])->group(function () {
    Route::get('/cliente/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('cliente.verification.verify');
    Route::post('/cliente/email/verification-notification', [VerificationController::class, 'resend'])->name('cliente.verification.send');
    });
    
    //Dashboard (autenticado) -> Rotas protegidas = apenas clientes autenticados podem acessar
    Route::middleware('auth:cliente')->group(function () {

        Route::get('/dashboard', [ClienteAuthController::class, 'index'])->name('cliente.dashboard'); // Dashboard do cliente
        Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout'); // Logout do cliente
        
    });

    // Verificação de e-mail

    //solicitação de verificação de e-mail
    Route::get('/email/verify', function () {
        return view('auth.empresa-verifique-email');
    })->middleware('auth:empresa')->name('verification.notice');

    //chamando a rota quando o link de verificação é clicado
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); //marca o e-mail como verificado
        return redirect()->route('empresa.dashboard'); // Redireciona para o dashboard 
    })->middleware(['auth:empresa', 'signed'])->name('verification.verify');

    //reenvio do link de verificação
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user('empresa')->sendEmailVerificationNotification();
        return back()->with('message', 'Link de verificação reenviado!');
    })->middleware(['auth:empresa', 'throttle:6,1'])->name('verification.send');

});

//ROTAS EMPRESA
Route::prefix('empresa')->group(function () {
    // Login - empresa
    Route::get('/login', [EmpresaAuthController::class, 'showLoginForm'])->name('empresa.login'); // Formulário de login
    Route::post('/login', [EmpresaAuthController::class, 'login'])->name('empresa.login.submit'); // Submissão do login

    // Cadastro - empresa
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

    Route::get('/verify-email/{token}', [VerificationController::class, 'verify'])->name('verify.email'); // Rota para verificar o e-mail

});

Route::get('/verify-email/{token}', [VerificationController::class, 'verify'])->name('verify.email');
// Rota para verificar o e-mail

//ESQUECEU SENHA
Route::get('/esqueceu-senha', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/esqueceu-senha', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('/resetar-senha/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/resetar-senha', [ResetPasswordController::class, 'reset'])->name('password.update');