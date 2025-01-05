<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\AbonoProveedor;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProveedorController extends Controller
{
    // Listar todos los proveedores
    public function index()
    {
        $proveedores = Proveedor::with('abonos')->get();
        return Inertia::render('Proveedores/Index', ['proveedores' => $proveedores]);
    }

    // Redirigir a la vista para crear un proveedor
    public function create()
    {
        return Inertia::render('Proveedores/Create');
    }

    // Guardar un nuevo proveedor
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
            'fecha_compra' => 'required|date', 
            'marca' => 'required|string',
            'cantidad_producto' => 'required|integer',
            'precio' => 'required|numeric',
        ]);

       
        $data['importe'] = $data['cantidad_producto'] * $data['precio'];
        $data['abono'] = 0;
        $data['saldo'] = $data['importe'];

        Proveedor::create($data);

        return redirect()->route('proveedores.index');
    }

    // Abonar monto a un proveedor
    public function abonar(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'monto_abonado' => 'required|numeric|min:0.01',
        ]);

        AbonoProveedor::create([
            'proveedor_id' => $proveedor->id,
            'monto_abonado' => $request->monto_abonado,
        ]);

        // Actualizar el saldo
        $proveedor->actualizarSaldo();

        return redirect()->route('proveedores.index');
    }

    // Ver detalles de los abonos de un proveedor
    public function detallesAbono(Proveedor $proveedor)
    {
        $abonos = $proveedor->abonos()->orderBy('created_at', 'desc')->get();

        return Inertia::render('Proveedores/DetallesAbono', [
            'proveedor' => $proveedor,
            'abonos' => $abonos,
        ]);
    }

    // Eliminar un proveedor y sus registros relacionados

    
    public function destroy($id)
    {
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
