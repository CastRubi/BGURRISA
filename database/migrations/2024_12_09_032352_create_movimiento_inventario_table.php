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
        Schema::create('movimiento_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade'); // Relación con el producto
            $table->decimal('cantidad', 10, 2); // Cantidad de productos en movimiento
            $table->enum('tipo_movimiento', ['entrada', 'salida']); // Tipo de movimiento: entrada o salida
            $table->timestamp('fecha_movimiento'); // Fecha y hora del movimiento
            $table->string('detalle')->nullable(); // Detalles sobre el movimiento (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimiento_inventario');
    }
};
