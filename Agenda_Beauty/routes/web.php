<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/register', 'Auth\AuthController@showRegisterForm')->name('register');
Route::post('/register', 'Auth\AuthController@register')->name('register.post');