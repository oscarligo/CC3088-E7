<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Course Model
 *
 * Representa un curso ofrecido en la plataforma de educación en línea.
 * Tabla: courses
 *
 * @property int $id Identificador único
 * @property int $teacher_id FK a users (profesor que imparte el curso)
 * @property int $category_id FK a categories (categoría del curso)
 * @property int $level_id FK a levels (nivel de dificultad)
 * @property string $title Título del curso
 * @property string $slug Slug único para URLs
 * @property string|null $description Descripción detallada
 * @property decimal $price Precio del curso (decimal de 8,2)
 * @property bool $is_published Indicador de publicación
 * @property \Illuminate\Support\Carbon|null $published_at Timestamp de publicación
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation User (teacher) Relación N:1 con el profesor que imparte (BelongsTo)
 * @relation Category Relación N:1 con la categoría (BelongsTo)
 * @relation Level Relación N:1 con el nivel (BelongsTo)
 * @relation Lesson Relación 1:N con lecciones (HasMany)
 * @relation Review Relación 1:N con reseñas (HasMany)
 * @relation Enrollment Relación 1:N con inscripciones (HasMany)
 * @relation Tag Relación N:N con etiquetas (BelongsToMany)
 */
class Course extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     * Todos los campos del curso pueden asignarse excepto timestamps e id.
     */
    protected $fillable = [
        'teacher_id',
        'category_id',
        'level_id',
        'title',
        'slug',
        'description',
        'price',
        'is_published',
        'published_at',
    ];

    /**
     * Casts de atributos.
     * - price: decimal con 2 posiciones decimales (8,2)
     * - is_published: conversión automática a boolean
     * - published_at: conversión a  datetime
     */
    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'course_tag');
    }
}