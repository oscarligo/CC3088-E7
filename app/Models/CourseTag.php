<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * CourseTag Model
 *
 * Modelo pivote explícito para la relación N:N entre Course y Tag.
 * Tabla: course_tag (tabla pivote)
 *
 * @property int $course_id FK a courses
 * @property int $tag_id FK a tags
 *
 * @relation Course Relación N:1 con el curso (BelongsTo)
 * @relation Tag Relación N:1 con la etiqueta (BelongsTo)
 */
class CourseTag extends Model
{
    use HasFactory;

    protected $table = 'course_tag';

    public $timestamps = false;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'course_id',
        'tag_id',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class);
    }
}