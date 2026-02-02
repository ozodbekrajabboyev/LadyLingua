<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\TranslatorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/translations', [TranslationController::class, 'index'])->name('translations');
Route::get('/translators', [TranslatorController::class, 'index'])->name('translators');

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
});

Route::get('/translation-detail', function (){
    return view('translations.show');
});

Route::get('/profile-detail', function (){
    return view('translators.profile');
});

Route::get('/order-create-page', function (){
    return view('orders.order-page');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

