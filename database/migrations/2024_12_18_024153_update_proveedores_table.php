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
        Schema::table('proveedores', function (Blueprint $table) {
            // Agregar columnas
            $table->string('nombre')->after('id'); // Nombre del proveedor
            $table->string('telefono')->after('nombre'); // Teléfono del proveedor
            $table->string('correo')->after('telefono'); // Correo del proveedor

            // Modificar columnas
            $table->dateTime('fecha_compra')->useCurrent()->change(); // Establecer fecha y hora actuales por defecto

            // Ajustes adicionales si es necesario
            // $table->decimal('saldo', 10, 2)->nullable()->change(); // Modificar tipo o valor por defecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Eliminar las columnas si es necesario
            $table->dropColumn(['nombre', 'telefono', 'correo']);
            
            // Revertir cambios (si modificaste alguna columna)
            $table->date('fecha_compra')->change();
        });
    }
};
