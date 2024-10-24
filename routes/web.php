<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});
 Route::get('/clientes', function () {
    return Inertia::render('Admin/Clientes');
})->name('clientes');

Route::get('/ventas', function () {
    return Inertia::render('Admin/Ventas');
})->name('ventas');

Route::get('/proveedores', function () {
    return Inertia::render('Admin/Proveedores');
})->name('proveedores');

Route::get('/productos', function () {
    return Inertia::render('Admin/Productos');
})->name('productos');

Route::get('/abonos', function () {
    return Inertia::render('Admin/Abonos');
})->name('abonos');
