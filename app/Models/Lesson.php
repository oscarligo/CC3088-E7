<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Lesson Model
 *
 * Representa una lección individual dentro de un curso.
 * Tabla: lessons
 *
 * @property int $id Identificador único
 * @property int $course_id FK a courses (curso propietario)
 * @property string $title Título de la lección
 * @property string $content Contenido o material de la lección
 * @property string|null $video_url URL del video (si aplica)
 * @property int $position Orden de la lección dentro del curso
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation Course Relación N:1 con el curso propietario (BelongsTo)
 */
class Lesson extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'course_id',
        'title',
        'content',
        'video_url',
        'position',
    ];

    /**
     * Casts de atributos.
     * - position: conversión a integer para ordenamiento garantizado
     */
    protected $casts = [
        'position' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}