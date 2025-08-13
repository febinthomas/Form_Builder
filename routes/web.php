<?php

use App\Http\Controllers\FormController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', '/forms')->name('dashboard');
    Route::get('forms', [FormController::class, 'index'])->name('form.list');
    Route::get('forms/create', [FormController::class, 'create'])->name('form.create');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
