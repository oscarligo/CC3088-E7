<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Category Model
 *
 * Representa una categoría de cursos (ej: Programación, Diseño, Idiomas).
 * Tabla: categories
 *
 * @property int $id Identificador único
 * @property string $name Nombre de la categoría
 * @property string $slug Slug único para URLs
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation Course Relación 1:N con cursos dentro de esta categoría (HasMany)
 */
class Category extends Model
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