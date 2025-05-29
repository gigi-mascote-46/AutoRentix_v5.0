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
// admin middleware
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\Authenticate;
use App\Http\Middleware\TrustProxies;
// user middleware
use App\Http\Middleware\Authenticate as UserAuthenticate;

require __DIR__.'/auth.php';

// ----------------------------------------------------------//
// 🌐 Páginas de teste para middleware
Route::get('/teste-admin', function () {
    return 'Middleware OK';
})->middleware(AdminMiddleware::class);

// ----------------------------------------------------------//

// 🌐 Páginas públicas - resources/js/Pages/Publico
// o path da rota é /resources/js/Pages/Publico

Route::name('publico.')->group(function () {
    Route::get('/', fn () => Inertia::render('Publico/Home'))->name('home');
    Route::get('/viaturas', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/viaturas/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

    // 🔍Páginas estáticas/informação
    Route::get('/sobre', [PageController::class, 'about'])->name('about');
    Route::get('/contacto', [PageController::class, 'contact'])->name('contact');
    Route::get('/terms', [PageController::class, 'terms']);
    Route::get('/complaint', [PageController::class, 'complaint']);
    Route::get('/help', [PageController::class, 'help'])->name('help');
    Route::get('/refund', [PageController::class, 'refund'])->name('refund');
});

// ----------------------------------------------------------//
// ✅ Área autenticada (clientes)
// o path da rota é /resources/js/Pages/AreaCliente

Route::middleware(['auth', 'verified'])->prefix('areacliente')->name('areacliente.')->group(function () {
    Route::get('/', fn () => Inertia::render('Publico/Home'))->name('home');
    Route::get('/dashboard', [PageController::class, 'clientDashboard'])->name('dashboard');
    Route::get('/perfil', fn () => Inertia::render('AreaCliente/Profile'))->name('profile');
    Route::get('/minhas-reservas', [ReservationController::class, 'index'])->name('my_reservations.index');
    Route::get('/minhas-reservas/{id}', [ReservationController::class, 'show'])->name('my_reservations.show');
    Route::get('/minhas-reservas/{id}/cancelar', [ReservationController::class, 'cancel'])->name('my_reservations.cancel');
    Route::get('/pagamentos', fn () => Inertia::render('AreaCliente/Payments'))->name('payments');
    Route::get('/viaturas', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/viaturas/{id}', [VehicleController::class, 'show'])->name('vehicles.show');
    Route::get('/viaturas/{id}/reservar', [ReservationController::class, 'create'])->name('vehicles.reserve');
    Route::post('/viaturas/{id}/reservar', [ReservationController::class, 'store'])->name('vehicles.reserve.store');
    Route::get('/viaturas/{id}/reservar/confirmar', [ReservationController::class, 'confirm'])->name('vehicles.reserve.confirm');
    Route::get('/viaturas/{id}/reservar/pagamento', [ReservationController::class, 'payment'])->name('vehicles.reserve.payment');
    Route::post('/viaturas/{id}/reservar/pagamento', [ReservationController::class, 'processPayment'])->name('vehicles.reserve.payment.process');
});

// ----------------------------------------------------------//
// 🔐 Área de administração
// o path da rota é /resources/js/Pages/AreaAdmin

Route::middleware(['web', 'auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/areaAdmin', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Viaturas para o admin
    Route::get('/viaturas', [AdminVehicleController::class, 'index'])->name('admin.vehicles.index');
    Route::get('/viaturas/criar', [AdminVehicleController::class, 'create'])->name('admin.vehicles.create');
    Route::post('/viaturas', [AdminVehicleController::class, 'store'])->name('admin.vehicles.store');
    Route::get('/viaturas/{id}/editar', [AdminVehicleController::class, 'edit'])->name('admin.vehicles.edit');
    Route::put('/viaturas/{id}', [AdminVehicleController::class, 'update'])->name('admin.vehicles.update');
    Route::delete('/viaturas/{id}', [AdminVehicleController::class, 'destroy'])->name('admin.vehicles.destroy');

    // Utilizadores
    Route::get('/utilizadores', [AdminUserController::class, 'index'])->name('admin.users.index');

    // Reservas
    Route::get('/reservas', [AdminReservationController::class, 'index'])->name('admin.reservations.index');

    // Pagamentos
    Route::get('/pagamentos', [AdminPaymentController::class, 'index'])->name('admin.payments.index');

    // Relatórios
    Route::get('/relatorios', function () {
        $sampleReports = [
            'totalReceita' => 12345.67,
            'totalReservas' => 89,
            'reservasPorMes' => [
                '01' => 5,
                '02' => 8,
                '03' => 12,
                '04' => 7,
                '05' => 10,
                '06' => 15,
                '07' => 9,
                '08' => 6,
                '09' => 10,
                '10' => 7,
                '11' => 0,
                '12' => 0,
            ],
        ];
        $sampleBrands = [
            ['id' => 1, 'name' => 'Marca A'],
            ['id' => 2, 'name' => 'Marca B'],
            ['id' => 3, 'name' => 'Marca C'],
        ];
        return Inertia::render('AreaAdmin/Admin/Reports', [
            'reports' => $sampleReports,
            'brands' => $sampleBrands,
        ]);
    })->name('reports');
});
