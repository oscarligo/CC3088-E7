<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla lessons para almacenar las lecciones de cada curso.
     *
     * Relación principal:
     * - course_id -> courses con borrado en cascada
     *
     * Campos relevantes:
     * - title, content, video_url y position para ordenar el contenido
     */
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('video_url')->nullable();
            $table->unsignedInteger('position')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Elimina la tabla de lecciones.
        Schema::dropIfExists('lessons');
    }
};