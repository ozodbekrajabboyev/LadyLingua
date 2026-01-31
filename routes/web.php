<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/translations', function () {
    return view('translations.index');
});

Route::get('/translators', function () {
    return view('translators.index');
});

Route::get('/orders', function () {
    return view('orders.index');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

