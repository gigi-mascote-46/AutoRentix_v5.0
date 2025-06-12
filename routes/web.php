<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PayPalController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\ChatController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Rotas Web
|--------------------------------------------------------------------------
|
| Aqui é onde você pode registrar rotas web para sua aplicação.
|
*/

// ======================================================
// Rotas Públicas (acessíveis sem autenticação)
// ======================================================

// Páginas estáticas
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund', [PageController::class, 'refund'])->name('refund');
Route::get('/complaint', [PageController::class, 'complaint'])->name('complaint');


// Listagem e detalhes de veículos
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');


// ======================================================
// Rotas Autenticadas (requerem login)
// ======================================================
Route::middleware('auth')->group(function () {

    // Gerenciamento de perfil do usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Sistema de chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{user}', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);


    // Dashboard e páginas do cliente
    Route::get('/dashboard', fn() => Inertia::render('AreaCliente/Dashboard'))->name('dashboard');
    Route::get('/my-profile', fn() => Inertia::render('AreaCliente/Profile'))->name('client.profile');
    Route::get('/my-payments', fn() => Inertia::render('AreaCliente/Payments'))->name('client.payments');

    // Listagem de veículos para re
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

    // Gestão de reservas do cliente
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [ReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [ReservationController::class, 'show'])->name('show');
        Route::post('/', [ReservationController::class, 'store'])->name('store');
        Route::get('/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('confirm');
        Route::post('/{reservation}/confirm', [ReservationController::class, 'processConfirmation'])->name('process');

        // Fluxo de pagamento
        Route::get('/{reservation}/payment', [ReservationController::class, 'payment'])->name('payment');
        Route::post('/{reservation}/payment', [ReservationController::class, 'processPayment'])->name('payment.process');
    });

    // Integração com PayPal
    Route::prefix('paypal')->name('paypal.')->group(function () {
        Route::post('/create-payment', [PayPalController::class, 'createPayment'])->name('create');
        Route::get('/execute-payment', [PayPalController::class, 'executePayment'])->name('execute');
        Route::get('/cancel-payment', [PayPalController::class, 'cancelPayment'])->name('cancel');
    });

    // Finalização de transações
    Route::get('/transaction/{reservation}', [ReservationController::class, 'transaction'])->name('reservations.transaction');
    Route::get('/finish-transaction/{reservation}', [ReservationController::class, 'finishTransaction'])->name('reservations.finish');
    Route::get('/reserva-confirmada/{reservation}', [ReservationController::class, 'confirmed'])->name('reservations.confirmed');
});

// ======================================================
// Rotas de Administração (requerem autenticação e permissão de admin)
// ======================================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard e relatórios
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    // Gestão de veículos (CRUD completo)
    Route::resource('vehicles', AdminVehicleController::class);

    // Gestão de usuários
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::get('/{user}', [AdminUserController::class, 'show'])->name('show');
        Route::patch('/{user}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Gestão de reservas
    Route::prefix('reservations')->name('reservations.')->group(function () {
        Route::get('/', [AdminReservationController::class, 'index'])->name('index');
        Route::get('/{reservation}', [AdminReservationController::class, 'show'])->name('show');
        Route::patch('/{reservation}', [AdminReservationController::class, 'update'])->name('update');
    });

    // Gestão de pagamentos
    Route::prefix('payments')->name('payments.')->group(function () {
        Route::get('/', [AdminPaymentController::class, 'index'])->name('index');
        Route::get('/{payment}', [AdminPaymentController::class, 'show'])->name('show');
    });
});

// ======================================================
// Rotas de Erro
// ======================================================
Route::get('/unauthorized', fn() => Inertia::render('Unauthorized'))->name('unauthorized');
Route::fallback(fn() => Inertia::render('NotFound'));

// ======================================================
// Rotas de Autenticação (geradas pelo Laravel)
// ======================================================
require __DIR__ . '/auth.php';
