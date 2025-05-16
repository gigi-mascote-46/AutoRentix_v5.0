<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\VehicleAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Admin\ReservationAdminController;
use App\Http\Controllers\Admin\PaymentAdminController;

// 🌐 Páginas públicas
Route::get('/', fn () => Inertia::render('Home'))->name('home');
Route::get('/viaturas', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/viaturas/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
Route::get('/sobre', fn () => Inertia::render('About'))->name('about');
Route::get('/contacto', fn () => Inertia::render('Contact'))->name('contact');
Route::get('/termos', fn () => Inertia::render('Terms'))->name('terms');
Route::get('/privacidade', fn () => Inertia::render('Privacy'))->name('privacy');

// ✅ Área autenticada (clientes)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/perfil', fn () => Inertia::render('Profile'))->name('profile');

    // Minhas reservas
    Route::get('/minhas-reservas', [ReservationController::class, 'index'])->name('my_reservations.index');
    Route::get('/minhas-reservas/{id}', [ReservationController::class, 'show'])->name('my_reservations.show');

    // Pagamentos
    Route::get('/pagamentos', fn () => Inertia::render('Payments'))->name('payments');
});

// 🔐 Área de administração
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    // Viaturas
    Route::get('/viaturas', [VehicleAdminController::class, 'index'])->name('vehicles.index');
    Route::get('/viaturas/criar', [VehicleAdminController::class, 'create'])->name('vehicles.create');
    Route::post('/viaturas', [VehicleAdminController::class, 'store'])->name('vehicles.store');
    Route::get('/viaturas/{id}/editar', [VehicleAdminController::class, 'edit'])->name('vehicles.edit');
    Route::put('/viaturas/{id}', [VehicleAdminController::class, 'update'])->name('vehicles.update');
    Route::delete('/viaturas/{id}', [VehicleAdminController::class, 'destroy'])->name('vehicles.destroy');

    // Utilizadores
    Route::get('/utilizadores', [UserAdminController::class, 'index'])->name('users.index');

    // Reservas
    Route::get('/reservas', [ReservationAdminController::class, 'index'])->name('reservations.index');

    // Pagamentos
    Route::get('/pagamentos', [PaymentAdminController::class, 'index'])->name('payments.index');

    // Relatórios
    Route::get('/relatorios', fn () => Inertia::render('Admin/Reports'))->name('reports');
});
