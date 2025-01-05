<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\AbonoProveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Muestra todos los productos con su cantidad disponible
    public function index()
    {
        $productos = Producto::with('movimientos')->get()->map(function ($producto) {
            $producto->cantidad_disponible = $producto->cantidad_disponible; // Accesor dinámico
            return $producto;
        });

        return Inertia::render('Productos/Index', [
            'productos' => $productos,
        ]);
    }

    // Muestra el formulario para crear un nuevo producto
    public function create()
    {
        return Inertia::render('Productos/Create');
    }

    // Almacena un nuevo producto
    public function store(Request $request)
    {
        $validated = $request->validate([
            'concepto' => 'required|string',
            'precio' => 'required|numeric',
        ]);

        Producto::create($validated);
        return redirect()->route('productos.index');
    }

    // Muestra el formulario de edición
    public function edit(Producto $producto)
    {
        return Inertia::render('Productos/Edit', [
            'producto' => $producto,
        ]);
    }

    // Actualiza un producto existente
    public function update(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'concepto' => 'sometimes|required|string',
            'precio' => 'sometimes|required|numeric',
        ]);

        $producto->update($validated);
        return redirect()->route('productos.index');
    }

    // Realizar venta y actualizar inventario
    public function realizarVenta(Request $request, $productoId)
    {
        $producto = Producto::findOrFail($productoId);
        $cantidadSolicitada = $request->input('cantidad');

        // Verificar si hay suficiente inventario
        if ($cantidadSolicitada > $producto->cantidad_disponible) {
            return back()->withErrors([
                'error' => "No hay suficiente inventario. Solo quedan {$producto->cantidad_disponible} unidades.",
            ]);
        }

        // Actualizar el inventario
        $producto->actualizarInventarioPorVenta($cantidadSolicitada);

        return redirect()->route('productos.index')->with('success', 'Venta realizada correctamente.');
    }
}
