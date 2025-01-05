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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();  // ID de la venta
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');  // Relación con la tabla clientes
            $table->decimal('total_compra', 10, 2);  // Total de la compra
            $table->decimal('abonos', 10, 2)->default(0);  // Total de los abonos realizados (se actualizará con la lógica)
            $table->decimal('total_pagar', 10, 2);  // Total a pagar (se actualizará como 'total_compra' - 'abonos')
            $table->timestamps();  // Fechas de creación y actualización
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
