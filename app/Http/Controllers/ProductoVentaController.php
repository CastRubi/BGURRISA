<?php
namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductoVentaController extends Controller
{
    /**
     * Muestra los productos disponibles para la venta.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $ventas = Venta::with('productos')->get();  // Asegúrate de traer los productos asociados a la venta
        return view('ventas.index', [
            'ventas' => $ventas,
        ]);

        
        $productos = Producto::all()->map(function ($producto) {
            $producto->cantidad_disponible = $producto->cantidadDisponible();
            return $producto;
        });

        return view('ventas.index', [
            'productos' => $productos,
        ]);
    }

    /**
     * Registrar una nueva venta y actualizar el inventario.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'productos' => 'required|array',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            $venta = Venta::create([
                'fecha' => now(),
            ]);

            foreach ($validated['productos'] as $producto) {
                $productoModelo = Producto::findOrFail($producto['id']);

                if ($producto['cantidad'] > $productoModelo->cantidadDisponible()) {
                    throw new \Exception("No hay suficiente stock para el producto: {$productoModelo->nombre}");
                }

                $productoModelo->actualizarInventarioPorVenta($producto['cantidad']);

                $venta->productos()->attach($producto['id'], [
                    'cantidad' => $producto['cantidad'],
                    'precio_unitario' => $productoModelo->precio,
                ]);
            }

            DB::commit();

            return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
