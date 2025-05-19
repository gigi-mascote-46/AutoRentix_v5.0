<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminVehicleController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminReservationController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\PageController;

// 🌐 Páginas públicas
Route::get('/', fn () => Inertia::render('Home'))->name('home');
Route::get('/viaturas', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/viaturas/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

// 🔍 Páginas estáticas/informação
Route::get('/sobre', [PageController::class, 'about'])->name('about');
Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
Route::get('/termos', [PageController::class, 'terms'])->name('terms');
Route::get('/privacidade', [PageController::class, 'privacy'])->name('privacy');



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
    Route::get('/viaturas', [AdminVehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/viaturas/criar', [AdminVehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/viaturas', [AdminVehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/viaturas/{id}/editar', [AdminVehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/viaturas/{id}', [AdminVehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/viaturas/{id}', [AdminVehicleController::class, 'destroy'])->name('vehicles.destroy');

    // Utilizadores
    Route::get('/utilizadores', [AdminUserController::class, 'index'])->name('users.index');

    // Reservas
    Route::get('/reservas', [AdminReservationController::class, 'index'])->name('reservations.index');

    // Pagamentos
    Route::get('/pagamentos', [AdminPaymentController::class, 'index'])->name('payments.index');

    // Relatórios
    Route::get('/relatorios', fn () => Inertia::render('Admin/Reports'))->name('reports');
});
