<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla categories para clasificar cursos por dominio o tema.
     *
     * Campos clave:
     * - name: nombre visible de la categoría
     * - slug: identificador único para URLs y filtros
     */
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Elimina la tabla de categorías.
        Schema::dropIfExists('categories');
    }
};