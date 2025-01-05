<?php

// app/Http/Controllers/VentasPorClienteController.php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;

class VentasPorClienteController extends Controller
{
    public function index()
{
    // Obtener todos los clientes con los datos necesarios
    $clientes = Cliente::all(['id', 'nombre']);  // Solo pasar los campos 'id' y 'nombre' para evitar datos innecesarios
    $ventas = Venta::with('cliente')->get();  // Obtener ventas con la relación cliente

    return Inertia('Ventas/Index', [
        'clientes' => $clientes,  // Pasamos los clientes a la vista
        'ventas' => $ventas,      // Pasamos las ventas a la vista
    ]);
}
}
