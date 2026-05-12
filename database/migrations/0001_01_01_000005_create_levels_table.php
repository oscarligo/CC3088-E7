<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla levels para representar el nivel de dificultad del curso.
     *
     * Campos clave:
     * - name: nivel legible para el usuario
     * - slug: identificador único para búsquedas y filtros
     */
    public function up(): void
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Elimina la tabla de niveles.
        Schema::dropIfExists('levels');
    }
};