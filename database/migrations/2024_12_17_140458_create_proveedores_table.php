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
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id(); // ID Proveedor
            $table->timestamp('fecha_compra')->useCurrent();
            $table->integer('cantidad_producto'); // Cantidad Producto
            $table->string('marca'); // Marca
            $table->decimal('precio', 10, 2); // Precio
            $table->decimal('importe', 10, 2); // Importe
            $table->decimal('abono', 10, 2)->default(0); // Abono
            $table->decimal('saldo', 10, 2); // Saldo
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proveedores');
    }
};
