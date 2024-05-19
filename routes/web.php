<?php

use App\Http\Controllers\CustomerWebsiteController;
use App\Http\Controllers\PizzaResetController;
use App\Http\Controllers\PizzaStatusController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', PosController::class)->name('pos');
    Route::get('/website', CustomerWebsiteController::class)->name('website');

    Route::post('/pizzas/{pizza}/status', PizzaStatusController::class)->name('pizzas.status');
    Route::post('/pizzas/{pizza}/reset', PizzaResetController::class)->name('pizzas.reset');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
