<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * User Model
 *
 * Representa un usuario del sistema (estudiante o profesor).
 * Tabla: users
 *
 * @property int $id Identificador único
 * @property string $name Nombre del usuario
 * @property string $email Email único
 * @property string $role Rol: 'student' o 'teacher'
 * @property string $password Contraseña hasheada
 * @property \Illuminate\Support\Carbon|null $email_verified_at Timestamp de verificación
 * @property string|null $remember_token Token de sesión
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation Profile Relación 1:1 con el perfil del usuario (HasOne)
 * @relation Course Relaciones 1:N con cursos impartidos (taughtCourses/HasMany)
 * @relation Enrollment Relación 1:N con inscripciones (HasMany)
 * @relation Review Relación 1:N con reseñas (HasMany)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Campos asignables en masa (fillable).
     * Estos campos pueden ser asignados mediante create() o update().
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * Campos ocultos en serialización JSON.
     * Protege datos sensibles al convertir el modelo a array o JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casts de atributos.
     * Define cómo se transforman los atributos al obtenerlos/asignarlos.
     * - email_verified_at: se convierte a Carbon datetime
     * - password: se hashea automáticamente al asignarse
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function taughtCourses(): HasMany
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }
}
