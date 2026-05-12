<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Enrollment Model
 *
 * Representa la inscripción de un usuario en un curso.
 * Tabla: enrollments
 *
 * @property int $id Identificador único
 * @property int $user_id FK a users (estudiante inscrito)
 * @property int $course_id FK a courses (curso en el que se inscribe)
 * @property \Illuminate\Support\Carbon $enrolled_at Timestamp de inscripción
 * @property string $status Estado de la inscripción (ej: 'active', 'completed')
 * @property decimal $price_paid Precio pagado (decimal 8,2)
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation User Relación N:1 con el estudiante (BelongsTo)
 * @relation Course Relación N:1 con el curso (BelongsTo)
 */
class Enrollment extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'user_id',
        'course_id',
        'enrolled_at',
        'status',
        'price_paid',
    ];

    /**
     * Casts de atributos.
     * - enrolled_at: conversión a Carbon datetime
     * - price_paid: conversión a decimal con 2 posiciones (8,2)
     */
    protected $casts = [
        'enrolled_at' => 'datetime',
        'price_paid' => 'decimal:2',
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