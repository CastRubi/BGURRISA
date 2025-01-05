<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\MovimientoInventario;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VentaController extends Controller
{
   
    public function index(Request $request)
{
    // Obtener el cliente_id desde la solicitud
    $clienteId = $request->input('cliente_id');
    
    // Obtener todos los clientes
    $clientes = Cliente::all();
    
    // Filtrar las ventas por cliente_id si se proporciona, de lo contrario obtener todas las ventas
    $ventasQuery = Venta::with('productos', 'cliente');
    
    if ($clienteId) {
        $ventasQuery->where('cliente_id', $clienteId);
    }

    // Obtener las ventas con la relación de productos y clientes
    $ventas = $ventasQuery->get();

    // Mapear las ventas para adaptarlas a la estructura que necesitas
    $ventasMapped = $ventas->map(function ($venta) {
        return [
            'id' => $venta->id,
            'cliente' => [
                'id' => $venta->cliente->id,
                'nombre' => $venta->cliente->nombre,
            ],
            'fecha' => $venta->created_at->format('Y-m-d H:i:s'), // Fecha y hora formateada
            'total_compra' => $venta->total_compra,
            'abonos' => $venta->abonos,
            'saldo' => $venta->total_pagar - $venta->abonos, // Calcular saldo
            'productos' => $venta->productos->map(function ($producto) {
                return [
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'cantidad' => $producto->pivot->cantidad,
                    'precio_unitario' => $producto->pivot->precio_unitario,
                    'importe' => $producto->pivot->cantidad * $producto->pivot->precio_unitario,
                ];
            }),
        ];
    });

    // Retornar la vista con los datos necesarios
    return Inertia::render('Ventas/Index', [
        'clientes' => $clientes,
        'ventas' => $ventasMapped,
    ]);
}

    
    

    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::all();

        return Inertia::render('Ventas/Create', [
            'clientes' => $clientes,
            'productos' => $productos,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'total_compra' => 'required|numeric|min:0',
            'abonos' => 'required|numeric|min:0',  // Validar que los abonos sean un número no negativo
        ]);
    
        // Crear la venta
        $venta = Venta::create([
            'cliente_id' => $request->cliente_id,
            'total_compra' => $request->total_compra,
            'abonos' => $request->abonos,  // Guardar el valor de los abonos
            'total_pagar' => $request->total_compra - $request->abonos,  // Calcular el total a pagar
        ]);
    
        // Agregar productos a la venta
        foreach ($request->productos as $productoVenta) {
            $producto = Producto::findOrFail($productoVenta['id']);
            if ($producto->cantidadDisponible < $productoVenta['cantidad']) {
                return back()->withErrors(['error' => 'No hay suficiente cantidad disponible del producto: ' . $producto->nombre]);
            }
    
            $venta->productos()->attach($producto->id, [
                'cantidad' => $productoVenta['cantidad'],
                'precio_unitario' => $productoVenta['precio_unitario'],
            ]);
    
            MovimientoInventario::create([
                'producto_id' => $producto->id,
                'cantidad' => -$productoVenta['cantidad'],
                'tipo_movimiento' => 'salida',
                'fecha_movimiento' => now(),
            ]);
        }
    
        return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito.');
    }
    

    public function show(Venta $venta)
    {
        $venta->load('cliente', 'productos');

        return Inertia::render('Ventas/Show', [
            'venta' => $venta,
        ]);
    }

    public function edit(Venta $venta)
    {
        $clientes = Cliente::all();
        $productos = Producto::all();
        $venta->load('productos');

        return Inertia::render('Ventas/Edit', [
            'venta' => $venta,
            'clientes' => $clientes,
            'productos' => $productos,
        ]);
    }

    public function update(Request $request, Venta $venta)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1',
            'productos.*.precio_unitario' => 'required|numeric|min:0',
            'total_compra' => 'required|numeric|min:0',
        ]);

        $venta->update([
            'cliente_id' => $request->cliente_id,
            'total_compra' => $request->total_compra,
            'total_pagar' => $request->total_compra - $venta->abonos,
        ]);

        $venta->productos()->detach();
        foreach ($request->productos as $productoVenta) {
            $venta->productos()->attach($productoVenta['id'], [
                'cantidad' => $productoVenta['cantidad'],
                'precio_unitario' => $productoVenta['precio_unitario'],
            ]);

            MovimientoInventario::create([
                'producto_id' => $productoVenta['id'],
                'tipo_movimiento' => 'actualización',
                'cantidad' => -$productoVenta['cantidad'],
                'fecha_movimiento' => now(),
            ]);
        }

        return redirect()->route('ventas.index')->with('success', 'Venta actualizada exitosamente.');
    }

    public function destroy(Venta $venta)
    {
        $venta->productos()->detach();
        $venta->delete();

        return redirect()->route('ventas.index')->with('success', 'Venta eliminada exitosamente.');
    }

   
    public function realizarAbono(Request $request, $ventaId)
    {
        // Buscar la venta con el ID proporcionado
        $venta = Venta::findOrFail($ventaId);
        $montoAbono = $request->input('monto_abono');
    
        // Verificar que el monto de abono sea válido
        if ($montoAbono <= 0) {
            return response()->json(['error' => 'Monto de abono inválido'], 400);
        }
    
        // Verificar si el abono excede el total pendiente de pago
        if ($montoAbono > $venta->total_pagar) {
            return response()->json(['error' => 'El abono no puede ser mayor al total pendiente de pago'], 400);
        }
    
        // Crear el abono y asociarlo a la venta
        $abono = new Abono();
        $abono->venta_id = $venta->id;
        $abono->monto_abono = $montoAbono;
        $abono->save();
    
        // Actualizar el campo 'abonos' de la venta sumando el monto de abono
        $venta->abonos = $venta->abonos + $montoAbono;  // Aquí te aseguras de que se sumen los abonos correctamente
    
        // Actualizar el total pendiente a pagar
        $venta->total_pagar = $venta->total_compra - $venta->abonos;
    
        // Guardar los cambios en la venta
        $venta->save();
    
        // Retornar respuesta de éxito
        return response()->json(['success' => 'Abono realizado correctamente'], 200);
    }
    
    
}
