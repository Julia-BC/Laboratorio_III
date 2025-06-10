<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ClienteAuthController;
use App\Http\Controllers\Auth\EmpresaAuthController;

//Rota para a página inicial -> Home
Route::get('/', function () {
    return view('home'); // resources/views/home.blade.php
});

// Aliases usados na home
Route::get('/login', fn() => redirect()->route('cliente.login.form'))->name('login');
Route::get('/cadastro', fn() => redirect()->route('cliente.register.form'))->name('cadastro');

//ROTAS CLIENTE
Route::prefix('cliente')->group(function () {

    // Login
    Route::get('/login', [ClienteAuthController::class, 'showLoginForm'])->name('cliente.login.form');
    Route::post('/login', [ClienteAuthController::class, 'login'])->name('cliente.login.submit');

    // Registro
    Route::get('/register', [ClienteAuthController::class, 'showRegisterForm'])->name('cliente.register.form');
    Route::post('/register', [ClienteAuthController::class, 'register'])->name('cliente.register.submit');

    //Dashboard (autenticado)
    Route::middleware('auth:cliente')->group(function () {
        Route::get('/dashboard', [ClienteAuthController::class, 'index'])->name('cliente.dashboard');
        Route::post('/logout', [ClienteAuthController::class, 'logout'])->name('cliente.logout');

});

//ROTAS EMPRESA
Route::prefix('empresa')->group(function () {
    // Login empresa
    Route::get('/login', [EmpresaAuthController::class, 'showLoginForm'])->name('empresa.login');
    Route::post('/login', [EmpresaAuthController::class, 'login'])->name('empresa.login.submit');

    // Registro empresa
    Route::get('/register', [EmpresaAuthController::class, 'showRegisterForm'])->name('empresa.register');
    Route::post('/register', [EmpresaAuthController::class, 'register'])->name('empresa.register.submit');

    // Dashboard empresa (autenticado)
    Route::middleware('auth:empresa')->group(function () {
        Route::get('/dashboard', [EmpresaAuthController::class, 'index'])->name('empresa.dashboard');
        Route::post('/logout', [EmpresaAuthController::class, 'logout'])->name('empresa.logout');
    });
});


});