<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Tabla asociada al modelo
    protected $table = 'productos';

    // Campos que son asignables en masa
    protected $fillable = [
        'concepto',
        'precio',
    ];

    /**
     * Relación con la tabla movimientos_inventario (uno a muchos).
     */
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    /**
     * Accesor para calcular la cantidad disponible.
     *
     * Calcula la cantidad disponible sumando las entradas y restando las salidas
     * desde la tabla movimientos_inventario.
     */
    public function getCantidadDisponibleAttribute()
    {
        // Sumar todas las entradas y restar todas las salidas
        $entradas = $this->movimientos()->where('tipo_movimiento', 'entrada')->sum('cantidad');
        $salidas = $this->movimientos()->where('tipo_movimiento', 'salida')->sum('cantidad');

        return $entradas - $salidas;
    }

    /**
     * Relación muchos a muchos con ventas a través de la tabla pivote 'venta_producto'.
     */
    public function ventas()
    {
        return $this->belongsToMany(Venta::class, 'productos_venta')
                    ->withPivot('cantidad', 'precio_unitario')
                    ->withTimestamps();
    }
    
}
