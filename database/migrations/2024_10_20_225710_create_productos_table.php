<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id(); // Esto crea una columna 'id' auto incrementable
        $table->string('concepto'); // Esto crea una columna 'concepto' tipo string
        $table->decimal('Precio', 10, 2);
        $table->decimal('total', 10, 2); // Esto crea una columna 'total' con precisión decimal
        $table->timestamps(); // Esto crea las columnas 'created_at' y 'updated_at'
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
