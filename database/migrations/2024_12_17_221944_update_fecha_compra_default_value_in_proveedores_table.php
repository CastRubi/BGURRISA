<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Modifica el campo fecha_compra para que tenga CURRENT_TIMESTAMP por defecto
            $table->dateTime('fecha_compra')->default(DB::raw('CURRENT_TIMESTAMP'))->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proveedores', function (Blueprint $table) {
            // Si necesitas revertir el cambio, elimina el valor predeterminado
            $table->dateTime('fecha_compra')->default(null)->change();
        });
    }
};
