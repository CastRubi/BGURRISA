<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade'); // Relación con la venta
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Relación con el producto
            $table->decimal('cantidad', 10, 2); // Cantidad del producto vendido
            $table->decimal('precio_unitario', 10, 2); // Precio del producto en la venta
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos_venta');
    }
};
