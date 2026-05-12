<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla reviews para registrar la calificación y comentario de un usuario sobre un curso.
     *
     * Relaciones principales:
     * - user_id -> users
     * - course_id -> courses
     *
     * Restricción importante:
     * - unique(['user_id', 'course_id']) evita reseñas duplicadas por usuario y curso
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        // Elimina la tabla de reseñas.
        Schema::dropIfExists('reviews');
    }
};