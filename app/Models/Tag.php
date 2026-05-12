<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Tag Model
 *
 * Representa una etiqueta temática que puede asociarse a múltiples cursos.
 * Tabla: tags
 * Relación: N:N con Course mediante tabla pivote 'course_tag'
 *
 * @property int $id Identificador único
 * @property string $name Nombre de la etiqueta
 * @property string $slug Slug único para URLs
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation Course Relación N:N con múltiples cursos (BelongsToMany)
 */
class Tag extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_tag');
    }
}