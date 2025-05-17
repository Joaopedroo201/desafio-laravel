<?php

use Illuminate\Support\Facades\Route;

// Página inicial
Route::get('/', function () {
    return view('welcome');
});

// Formulários de autenticação e cadastro
Route::view('/login', 'auth.login')->name('login');
Route::view('/register', 'auth.register')->name('register');

// Página protegida 
Route::view('/dashboard', 'dashboard')->name('dashboard');