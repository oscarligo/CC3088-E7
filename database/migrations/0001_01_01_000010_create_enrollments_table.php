<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla enrollments para registrar inscripciones de usuarios en cursos.
     *
     * Relaciones principales:
     * - user_id -> users
     * - course_id -> courses
     *
     * Restricción importante:
     * - unique(['user_id', 'course_id']) evita inscripciones duplicadas
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('course_id')->constrained()->cascadeOnDelete();
            $table->timestamp('enrolled_at')->useCurrent();
            $table->string('status')->default('active');
            $table->decimal('price_paid', 8, 2)->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'course_id']);
        });
    }

    public function down(): void
    {
        // Elimina la tabla de inscripciones.
        Schema::dropIfExists('enrollments');
    }
};