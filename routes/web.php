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
use App\Http\Controllers\MailTestController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::get('/help', [PageController::class, 'help'])->name('help');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/refund', [PageController::class, 'refund'])->name('refund');
Route::get('/complaint', [PageController::class, 'complaint'])->name('complaint');

//Chat routes
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/messages/{user}', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);
});


// Vehicle routes (public)
Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

// Authentication required routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Client area routes
    Route::get('/dashboard', function () {
        return Inertia::render('AreaCliente/Dashboard');
    })->name('dashboard');

    Route::get('/my-profile', function () {
        return Inertia::render('AreaCliente/Profile');
    })->name('client.profile');

    Route::get('/my-payments', function () {
        return Inertia::render('AreaCliente/Payments');
    })->name('client.payments');

    // Reservation routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}/confirm', [ReservationController::class, 'confirm'])->name('reservations.confirm');
    Route::post('/reservations/{reservation}/confirm', [ReservationController::class, 'processConfirmation'])->name('reservations.process');

    // Payment routes
    Route::get('/reservations/{reservation}/payment', [ReservationController::class, 'payment'])->name('reservations.payment');
    Route::post('/reservations/{reservation}/payment', [ReservationController::class, 'processPayment'])->name('reservations.payment.process');

    // PayPal routes
    Route::post('/paypal/create-payment', [PayPalController::class, 'createPayment'])->name('paypal.create');
    Route::get('/paypal/execute-payment', [PayPalController::class, 'executePayment'])->name('paypal.execute');
    Route::get('/paypal/cancel-payment', [PayPalController::class, 'cancelPayment'])->name('paypal.cancel');

    // Transaction routes
    Route::get('/transaction/{reservation}', [ReservationController::class, 'transaction'])->name('reservations.transaction');
    Route::get('/finish-transaction/{reservation}', [ReservationController::class, 'finishTransaction'])->name('reservations.finish');
    Route::get('/reserva-confirmada/{reservation}', [ReservationController::class, 'confirmed'])->name('reservations.confirmed');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('reports');

    // Admin vehicle management
    Route::resource('vehicles', AdminVehicleController::class);

    // Admin user management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');

    // Admin reservation management
    Route::get('/reservations', [AdminReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{reservation}', [AdminReservationController::class, 'show'])->name('reservations.show');
    Route::patch('/reservations/{reservation}', [AdminReservationController::class, 'update'])->name('reservations.update');

    // Admin payment management
    Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [AdminPaymentController::class, 'show'])->name('payments.show');
});

// Error pages
Route::get('/unauthorized', function () {
    return Inertia::render('Unauthorized');
})->name('unauthorized');

Route::fallback(function () {
    return Inertia::render('NotFound');
});

require __DIR__.'/auth.php';
use App\Http\Middleware\AdminMiddleware;

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
    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('vehicles.show');

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

// PayPal payment routes
Route::prefix('paypal')->name('paypal.')->group(function () {
    Route::get('/transaction', [PayPalController::class, 'createTransaction'])->name('createTransaction');
    Route::post('/transaction/process', [PayPalController::class, 'processTransaction'])->name('processTransaction');
    Route::get('/transaction/success', [PayPalController::class, 'successTransaction'])->name('successTransaction');
    Route::get('/transaction/cancel', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');
    Route::get('/transaction/finish', [PayPalController::class, 'finishTransaction'])->name('finishTransaction');
});

// ----------------------------------------------------------//
// 🔐 Área de administração
// o path da rota é /resources/js/Pages/AreaAdmin

Route::prefix('areaAdmin')->middleware(['web', 'auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('areaAdmin.dashboard');

    // Viaturas para o admin
    Route::resource('viaturas', AdminVehicleController::class, ['as' => 'areaAdmin']);

    // Utilizadores
    Route::resource('utilizadores', AdminUserController::class, ['as' => 'areaAdmin']);

    // Reservas
    Route::resource('reservas', AdminReservationController::class, ['as' => 'areaAdmin']);

    // Pagamentos
    Route::resource('pagamentos', AdminPaymentController::class, ['as' => 'areaAdmin']);

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
