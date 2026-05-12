<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla pivote course_tag para modelar la relación many-to-many entre cursos y etiquetas.
     *
     * Restricción importante:
     * - primary(['course_id', 'tag_id']) impide duplicados en la asociación
     */
    public function up(): void
    {
        Schema::create('course_tag', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tag_id')->constrained()->cascadeOnDelete();

            $table->primary(['course_id', 'tag_id']);
        });
    }

    public function down(): void
    {
        // Elimina la tabla pivote de relación many-to-many.
        Schema::dropIfExists('course_tag');
    }
};