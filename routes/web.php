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

// Show individual translator and translation - support both GET and POST methods
Route::match(['GET', 'POST'], '/translator/{id}', [TranslatorController::class, 'show'])
    ->name('translator.show')
    ->middleware('throttle:30,1'); // 30 requests per minute

Route::match(['GET', 'POST'], '/translation/{id}', [TranslationController::class, 'show'])
    ->name('translation.show')
    ->middleware('throttle:30,1'); // 30 requests per minute


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

