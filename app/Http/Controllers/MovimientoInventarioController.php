<?php
namespace App\Http\Controllers;

use App\Models\MovimientoInventario;
use App\Models\Producto;
use Illuminate\Http\Request;

class MovimientoInventarioController extends Controller
{
    // Muestra la lista de movimientos
   // Muestra la lista de movimientos
public function index()
{
    $movimientos = MovimientoInventario::with('producto')->get();
    return inertia('MovimientoInventario/Index', [
        'movimientos' => $movimientos,
    ]);
}

// Muestra el formulario de creación
public function create()
{
    $productos = Producto::all();
    return inertia('MovimientoInventario/Create', [
        'productos' => $productos,
    ]);
}

// Muestra el formulario de edición
public function edit($id)
{
    $movimiento = MovimientoInventario::findOrFail($id);
    return inertia('MovimientoInventario/Edit', [
        'movimiento' => $movimiento
    ]);
}

// Muestra un producto con su cantidad disponible
public function show($id)
{
    $producto = Producto::findOrFail($id);
    $cantidadDisponible = $producto->cantidadDisponible; // Llama al accesor cantidadDisponible

    return inertia('Producto/Show', [
        'producto' => $producto,
        'cantidadDisponible' => $cantidadDisponible,
    ]);
}

// Almacena un nuevo movimiento
public function store(Request $request)
{
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|numeric|min:1',
        'tipo_movimiento' => 'required|in:entrada,salida',
        'fecha_movimiento' => 'required|date',
    ]);

    MovimientoInventario::create([
        'producto_id' => $request->producto_id,
        'cantidad' => $request->cantidad,
        'tipo_movimiento' => $request->tipo_movimiento,
        'fecha_movimiento' => $request->fecha_movimiento,
    ]);

    return redirect()->route('movimiento-inventario.index')->with('success', 'Movimiento creado exitosamente.');
}

// Actualiza un movimiento existente
public function update(Request $request, $id)
{
    // Valida los datos del movimiento
    $request->validate([
        'producto_id' => 'required|exists:productos,id',
        'cantidad' => 'required|numeric|min:1',
        'tipo_movimiento' => 'required|in:entrada,salida',
        'fecha_movimiento' => 'required|date',
    ]);

    // Encuentra el movimiento de inventario y actualízalo
    $movimiento = MovimientoInventario::findOrFail($id);
    $movimiento->update([
        'producto_id' => $request->producto_id,
        'cantidad' => $request->cantidad,
        'tipo_movimiento' => $request->tipo_movimiento,
        'fecha_movimiento' => $request->fecha_movimiento,
    ]);

    return redirect()->route('movimiento-inventario.index')->with('success', 'Movimiento actualizado exitosamente.');
}

// Elimina un movimiento de inventario
public function destroy($id)
{
    $movimiento = MovimientoInventario::findOrFail($id);
    $movimiento->delete();

    return redirect()->route('movimiento-inventario.index')->with('success', 'Movimiento eliminado correctamente.');
}

}

