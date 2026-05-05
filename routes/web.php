<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('supplier-sign-up', [App\Http\Controllers\IndexController::class, 'supplierRegister'])->name('supplier-sign-up');


