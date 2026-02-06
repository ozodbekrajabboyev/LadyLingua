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

// Authentication routes
Route::get('/login', function() {
    return redirect('/platform/login');
})->name('login');

// Show individual translator and translation - support both GET and POST methods
Route::match(['GET', 'POST'], '/translator/{id}', [TranslatorController::class, 'show'])
    ->name('translator.show')
    ->middleware('throttle:30,1'); // 30 requests per minute

Route::match(['GET', 'POST'], '/translation/{id}', [TranslationController::class, 'show'])
    ->name('translation.show')
    ->middleware('throttle:30,1'); // 30 requests per minute

Route::middleware('auth')->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders');

    // Order creation routes
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // AJAX route for searching existing works
    Route::get('/api/works/search', [OrderController::class, 'searchWorks'])->name('works.search');
});

Route::post('/logout', [UserController::class, 'logout'])->name('logout');

