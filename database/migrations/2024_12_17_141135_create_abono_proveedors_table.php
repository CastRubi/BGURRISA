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
        // Crear la tabla abonos_proveedores
        Schema::create('abonos_proveedores', function (Blueprint $table) {
            $table->id(); // ID único de cada abono
            // Relación con la tabla proveedores
            $table->foreignId('proveedor_id')->constrained('proveedores')->onDelete('cascade');
            // Monto abonado
            $table->decimal('monto_abonado', 10, 2);
            // Fecha del abono, utilizando la fecha y hora actual por defecto
            $table->timestamp('fecha_abono')->useCurrent();
            $table->timestamps(); // Timestamps: created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la tabla abonos_proveedores
        Schema::dropIfExists('abonos_proveedores');
    }
};
