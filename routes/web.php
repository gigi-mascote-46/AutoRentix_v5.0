<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\EmailConfirmationReservationController;
use App\Http\Controllers\ReservationConfirmationMailController;




Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//  rota para o formulario de reserva
Route::get('/reserva/confirmada', function () {
    return Inertia::render('ReservaConfirmada', [
        'client' => 'João Silva',
        'local' => 'Filial Norte'
    ]);
});

// rota para tratar o envio do email
Route::post('/enviar-email', [ReservationConfirmationMailController::class, 'sendReservationEmail'])
    ->middleware('auth')
    ->name('send.email');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
