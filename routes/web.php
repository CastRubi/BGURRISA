<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\AbonoController;
use App\Http\Controllers\MovimientoInventarioController;
use App\Http\Controllers\VentasPorClienteController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])
    ->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        Route::resource('clientes', ClienteController::class);
        Route::resource('productos', ProductoController::class);
        Route::resource('ventas', VentaController::class);
        Route::resource('proveedores', ProveedorController::class);

        Route::prefix('admin')->group(function () {
            Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
        });

        Route::post('/ventas/{venta}/abonos', [VentaController::class, 'realizarAbono']);

     
        
        Route::middleware(['auth'])->group(function () {
            Route::get('/abonos', [AbonoController::class, 'index'])->name('abonos.index');
            Route::get('/abonos/create', [AbonoController::class, 'create'])->name('abonos.create');
            Route::post('/abonos', [AbonoController::class, 'store'])->name('abonos.store');
        });
        


    Route::prefix('proveedores')->group(function () {
    Route::get('/', [ProveedorController::class, 'index'])->name('proveedores.index');
    Route::get('/create', [ProveedorController::class, 'create'])->name('proveedores.create');
    Route::post('/', [ProveedorController::class, 'store'])->name('proveedores.store');
    Route::delete('/{proveedor}', [ProveedorController::class, 'destroy'])->name('proveedores.destroy');
    Route::post('/{proveedor}/abonar', [ProveedorController::class, 'abonar'])->name('proveedores.abonar');
    Route::get('/{proveedor}/detalles-abono', [ProveedorController::class, 'detallesAbono'])->name('proveedores.detallesAbono');
});

 

Route::get('/ventas', [VentaController::class, 'index']);

        Route::resource('movimiento-inventario', MovimientoInventarioController::class);
        Route::get('/ventas-por-cliente', [VentasPorClienteController::class, 'index']);
       
    });
