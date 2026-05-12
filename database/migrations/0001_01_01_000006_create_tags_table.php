<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla tags para etiquetar cursos con términos temáticos.
     *
     * Campos clave:
     * - name: etiqueta visible
     * - slug: identificador único para la relación many-to-many
     */
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Elimina la tabla de etiquetas.
        Schema::dropIfExists('tags');
    }
};