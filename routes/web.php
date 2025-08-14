<?php

use App\Http\Controllers\Forms\FormController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::redirect('dashboard', '/forms')->name('dashboard');
    Route::get('forms', [FormController::class, 'index'])->name('form.list');
    Route::get('forms/create', [FormController::class, 'create'])->name('form.create');
    Route::post('forms/store', [FormController::class, 'store'])->name('form.store');
    Route::get('forms/{form}', [FormController::class, 'show'])->name('form.show');
});

require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
