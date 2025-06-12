<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Pages
use App\Http\Controllers\PageController;
use App\Http\Controllers\VehicleController;

// Authenticated
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PayPalController;

// Admin
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminPaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::name('public.')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/about', [PageController::class, 'about'])->name('about');
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/help', [PageController::class, 'help'])->name('help');
    Route::get('/terms', [PageController::class, 'terms'])->name('terms');
    Route::get('/refund', [PageController::class, 'refund'])->name('refund');
    Route::get('/complaint', [PageController::class, 'complaint'])->name('complaint');

    // **Rotas para listagem e detalhe de veículos**
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
});

// Authenticated Routes (Chat)
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{user}', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});

// Authenticated Routes (Profile)
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// Client Area (dashboard, reservations, profile, payments)
Route::middleware(['auth', 'verified'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Client/Dashboard'))->name('dashboard');
    Route::get('/profile', fn () => Inertia::render('Client/Profile'))->name('profile');
    Route::get('/payments', fn () => Inertia::render('Client/Payments'))->name('payments');

    // User reservations
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('/reservations/{id}/cancel', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Reservation Flow
    Route::get('/vehicles/{id}/reserve', [ReservationController::class, 'create'])->name('vehicles.reserve');
    Route::post('/vehicles/{id}/reserve', [ReservationController::class, 'store'])->name('vehicles.reserve.store');
    Route::get('/vehicles/{id}/reserve/confirm', [ReservationController::class, 'confirm'])->name('vehicles.reserve.confirm');
    Route::get('/vehicles/{id}/reserve/payment', [ReservationController::class, 'payment'])->name('vehicles.reserve.payment');
    Route::post('/vehicles/{id}/reserve/payment', [ReservationController::class, 'processPayment'])->name('vehicles.reserve.payment.process');
});

// PayPal Routes
Route::prefix('paypal')->name('paypal.')->group(function () {
    Route::get('/transaction', [PayPalController::class, 'createTransaction'])->name('create');
    Route::post('/transaction/process', [PayPalController::class, 'processTransaction'])->name('process');
    Route::get('/transaction/success', [PayPalController::class, 'successTransaction'])->name('success');
    Route::get('/transaction/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancel');
    Route::get('/transaction/finish', [PayPalController::class, 'finishTransaction'])->name('finish');
});

// Admin Area
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    // Vehicles
    Route::resource('vehicles', AdminVehicleController::class);

    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Reservations
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}', [AdminReservationController::class, 'update'])->name('reservations.update');

    // Payments
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
});

// Error Pages
Route::get('/unauthorized', fn () => Inertia::render('Unauthorized'))->name('unauthorized');
Route::fallback(fn () => Inertia::render('NotFound'));

require __DIR__.'/auth.php';
