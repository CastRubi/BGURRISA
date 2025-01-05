<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbonoProveedor extends Model
{ 
    protected $table = 'abonos_proveedores';
    protected $fillable = [
        'proveedor_id',
        'monto_abonado',
        'fecha_abono',
    ];

    // Relación con proveedores
    public function proveedor(): BelongsTo
    {
        return $this->belongsTo(Proveedor::class);
    }
}
