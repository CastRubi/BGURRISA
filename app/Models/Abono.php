<?php

namespace App\Models;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{
    use HasFactory;

    protected $fillable = ['venta_id', 'monto_abono', 'fecha_abono'];



    // Relación con la tabla de ventas
    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
    
}
