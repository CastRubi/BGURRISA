<?php

namespace App\Http\Controllers;

use App\Models\Abono;
use App\Models\Venta;
use Illuminate\Http\Request;
use Inertia\Inertia;


class AbonoController extends Controller
{
    public function index()
    {
        // Obtener todos los abonos
        $abonos = Abono::with('venta')->get();
        return Inertia::render('Abonos/Index', [
            'abonos' => $abonos
        ]);
    }

    public function create()
    {
        // Mostrar formulario para crear un abono
        return Inertia::render('Abonos/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'monto_abono' => 'required|numeric|min:0.01',
        ]);
    
        // Crear el abono
        $abono = Abono::create([
            'venta_id' => $request->input('venta_id'),
            'monto_abono' => $request->input('monto_abono'),
        ]);
    
        // Actualizar la venta
        $venta = Venta::find($abono->venta_id);
    
        if ($venta) {
            // Recalcular los abonos acumulados sumando el nuevo abono
            $venta->abonos += $abono->monto_abono;
    
            // Recalcular el total a pagar
            $venta->total_pagar = $venta->total_compra - $venta->abonos;
    
            // Guardar los cambios en la venta
            $venta->save();
        }
    
        return redirect()->back()->with('success', 'Abono realizado correctamente y venta actualizada.');
    }
    
    
    
    
}
