<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimiento_inventario';

    protected $fillable = [
        'producto_id',
        'cantidad',
        'tipo_movimiento',
        'fecha_movimiento',
        'detalle',
    ];

    // Relación con el modelo Producto (cada movimiento de inventario pertenece a un producto)
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
