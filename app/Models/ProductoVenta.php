<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoVenta extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla asociada en la base de datos
    protected $table = 'productos_venta';

    // Campos que se pueden asignar masivamente
    protected $fillable = [
        'venta_id',
        'producto_id',
        'cantidad',
        'precio_unitario',
    ];

    /**
     * Relación con el modelo Producto.
     * Cada registro de esta tabla pertenece a un producto específico.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con el modelo Venta.
     * Cada registro de esta tabla pertenece a una venta específica.
     */
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
