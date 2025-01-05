<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'cliente_id',
        'total_compra',
        'abonos',
        'total_pagar',
    ];

    /**
     * Relación con el modelo Producto a través de la tabla intermedia "productos_venta".
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
   

  
public function productosVenta()
{
    return $this->hasMany(ProductoVenta::class);
}



    /**
     * Relación con el modelo Cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Calcula el monto total de la venta basado en los productos asociados.
     *
     * @return float
     */
    public function calcularTotalCompra()
    {
        return $this->productos->sum(function ($producto) {
            return $producto->pivot->cantidad * $producto->pivot->precio_unitario;
        });
    }

    /**
     * Verifica si la venta tiene saldo pendiente.
     *
     * @return bool
     */
    public function tieneSaldoPendiente()
    {
        return $this->total_pagar > $this->abonos;
    }

    /**
     * Relación con el modelo MovimientoInventario (si es necesario para rastrear movimientos de inventario).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movimientosInventario()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    public function productos()
{
    return $this->belongsToMany(Producto::class, 'productos_venta')
                ->withPivot('cantidad', 'precio_unitario')
                ->withTimestamps();
}

     // Relación con abonos
     public function abonos()
     {
         return $this->hasMany(Abono::class); // Modelo que maneja los abonos
     }
     
     public function recalcularAbonos()
     {
         // Recalcular el total de abonos desde la tabla `abonos`
         $this->abonos = $this->abonos()->sum('monto_abono');
         $this->total_pagar = $this->total_compra - $this->abonos;
         $this->save();
     }
      

}
