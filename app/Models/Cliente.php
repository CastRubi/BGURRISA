<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'email', 'telefono'];

    // Relación con las ventas
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
