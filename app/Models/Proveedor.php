<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Proveedor extends Model
{
    protected $table = 'proveedores'; // Nombre correcto de la tabla
    
    protected $fillable = [
        'nombre',          // Nombre del proveedor
        'telefono',        // Teléfono del proveedor
        'correo',          // Correo del proveedor
        'fecha_compra',    // Fecha de compra
        'marca',           // Marca
        'cantidad_producto', // Cantidad de productos
        'precio',          // Precio del producto
        'importe',         // Importe total
        'abono',           // Abono realizado
        'saldo',           // Saldo pendiente
    ];

    // Relación con abonos
    public function abonos(): HasMany
    {
        return $this->hasMany(AbonoProveedor::class);
    }

    // Método para calcular el saldo actual
    public function actualizarSaldo()
    {
        $totalAbonos = $this->abonos()->sum('monto_abonado');
        $this->abono = $totalAbonos;
        $this->saldo = $this->importe - $totalAbonos;
        $this->save();
    }
}
