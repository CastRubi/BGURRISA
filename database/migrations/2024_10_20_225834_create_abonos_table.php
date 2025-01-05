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
        Schema::create('abonos', function (Blueprint $table) {
            $table->id();  // ID del abono
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade');  // Relación con la tabla ventas
            $table->decimal('monto_abono', 10, 2);  // Monto del abono
            $table->timestamp('fecha_abono')->useCurrent();  // Fecha en que se realiza el abono (por defecto, la fecha y hora actual)
            $table->timestamps();  // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abonos');
    }
};
