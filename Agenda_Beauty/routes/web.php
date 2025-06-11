<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\Auth\EmpresaAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

    //solicitação de verificação de e-mail
    Route::get('/email/verify', function () {
        return view('auth.empresa-verifique-email');
    })->middleware('auth:empresa')->name('verification.notice');

    //chamando a rota quando o link de verificação é clicado
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill(); //marca o e-mail como verificado
        return redirect()->route('empresa.dashboard'); // Redireciona para o dashboard da empresa
    })->middleware(['auth:empresa', 'signed'])->name('verification.verify');

    //reenvio do link de verificação
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user('empresa')->sendEmailVerificationNotification();
        return back()->with('message', 'Link de verificação reenviado!');
    })->middleware(['auth:empresa', 'throttle:6,1'])->name('verification.send');

});