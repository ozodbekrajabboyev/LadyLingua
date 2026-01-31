<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/translations', [TranslationController::class, 'index'])->name('translations');
Route::get('/translators', [TranslatorController::class, 'index'])->name('translators');

Route::get('/orders', function () {
    return view('orders.index');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

