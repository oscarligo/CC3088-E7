<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Level Model
 *
 * Representa un nivel de dificultad de curso (ej: Básico, Intermedio, Avanzado).
 * Tabla: levels
 *
 * @property int $id Identificador único
 * @property string $name Nombre del nivel
 * @property string $slug Slug único para URLs
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation Course Relación 1:N con cursos de este nivel (HasMany)
 */
class Level extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}