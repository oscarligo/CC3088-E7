<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Review Model
 *
 * Representa una reseña o calificación de un usuario sobre un curso.
 * Tabla: reviews
 *
 * @property int $id Identificador único
 * @property int $user_id FK a users (autor de la reseña)
 * @property int $course_id FK a courses (curso reseñado)
 * @property int $rating Calificación numérica (1-5 típicamente)
 * @property string|null $comment Texto del comentario
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation User Relación N:1 con el usuario que escribe la reseña (BelongsTo)
 * @relation Course Relación N:1 con el curso reseñado (BelongsTo)
 */
class Review extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'rating',
        'comment',
    ];

    /**
     * Casts de atributos.
     * - rating: conversión a integer para garantizar tipo numérico
     */
    protected $casts = [
        'rating' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}