<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Venta;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClienteController extends Controller
{
    /**
     * Mostrar la lista de clientes.
     */
    public function index(Request $request)
    {
        $clientes = Cliente::all();

        $ventas = [];
        if ($request->has('cliente_id')) {
            $ventas = Venta::with(['productos', 'cliente'])
                ->where('cliente_id', $request->cliente_id)
                ->get()
                ->map(function ($venta) {
                    return [
                        'id' => $venta->id,
                        'cliente' => $venta->cliente,
                        'created_at' => $venta->created_at->format('Y-m-d H:i'),
                        'total_compra' => $venta->productos->sum(function ($producto) {
                            return $producto->pivot->cantidad * $producto->pivot->precio_unitario;
                        }),
                        'productos' => $venta->productos->map(function ($producto) {
                            return [
                                'concepto' => $producto->concepto,
                                'cantidad' => $producto->pivot->cantidad,
                                'precio_unitario' => $producto->pivot->precio_unitario,
                            ];
                        }),
                    ];
                });
        }

        return Inertia::render('Clientes/Index', [
            'clientes' => $clientes,
            'ventas' => $ventas,
        ]);
    }

   

    public function obtenerVentas($id)
{
    $cliente = Cliente::with('ventas')->findOrFail($id);
    return response()->json([
        'cliente' => $cliente,
        'ventas' => $cliente->ventas,
    ]);
}

    /**
     * Mostrar el formulario para crear un nuevo cliente.
     */
    public function create()
    {
        return Inertia::render('Clientes/Create'); // Renderiza la vista para crear un cliente
    }

    /**
     * Almacenar un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string',
            'email' => 'nullable|email|unique:clientes,email',
            'telefono' => 'required|string',
        ]);

        // Crear el cliente en la base de datos
        Cliente::create($validated);

        // Redirigir a la lista de clientes con mensaje de éxito
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente creado exitosamente');
    }

    /**
     * Mostrar un cliente específico.
     */
    public function show(Cliente $cliente)
    {
        return Inertia::render('Clientes/Show', [
            'cliente' => $cliente, // Envía el cliente a la vista
        ]);
    }

    /**
     * Mostrar el formulario para editar un cliente específico.
     */
    public function edit(Cliente $cliente)
    {
        return Inertia::render('Clientes/Edit', [
            'cliente' => $cliente, // Envía el cliente a la vista para edición
        ]);
    }

    /**
     * Actualizar un cliente específico.
     */
    public function update(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'nombre' => 'sometimes|required|string',
            'email' => 'sometimes|nullable|email|unique:clientes,email,' . $cliente->id,
            'telefono' => 'sometimes|required|string',
        ]);

        // Actualiza el cliente en la base de datos
        $cliente->update($validated);

        // Redirige a la lista de clientes con mensaje de éxito
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente actualizado exitosamente');
    }

    /**
     * Eliminar un cliente específico.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete(); // Elimina el cliente de la base de datos

        // Redirige a la lista de clientes con mensaje de éxito
        return redirect()->route('clientes.index')
                         ->with('success', 'Cliente eliminado exitosamente');
    }
}
