<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crea la tabla profiles para almacenar información adicional del usuario.
     *
     * Relación principal:
     * - user_id es una FK única a users para modelar una relación 1:1.
     *
     * Campos relevantes:
     * - bio, avatar_url, birth_date y social_links
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->text('bio')->nullable();
            $table->string('avatar_url')->nullable();
            $table->date('birth_date')->nullable();
            $table->json('social_links')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        // Elimina la tabla de perfiles y revierte la relación 1:1 con users.
        Schema::dropIfExists('profiles');
    }
};