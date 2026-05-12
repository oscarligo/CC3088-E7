<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Profile Model
 *
 * Información adicional y personal de cada usuario (extensión de User).
 * Tabla: profiles
 * Relación: 1:1 con User (cada usuario tiene exactamente un perfil)
 *
 * @property int $id Identificador único
 * @property int $user_id FK único a users (relación 1:1, unique constraint)
 * @property string|null $bio Biografía o descripción personal
 * @property string|null $avatar_url URL del avatar/foto de perfil
 * @property \Illuminate\Support\Carbon|null $birth_date Fecha de nacimiento
 * @property array|null $social_links Enlaces a redes sociales (JSON)
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 *
 * @relation User Relación N:1 inversa con el usuario propietario (BelongsTo)
 */
class Profile extends Model
{
    use HasFactory;

    /**
     * Campos asignables en masa (fillable).
     */
    protected $fillable = [
        'user_id',
        'bio',
        'avatar_url',
        'birth_date',
        'social_links',
    ];

    /**
     * Casts de atributos.
     * - birth_date: conversión a Carbon date (sin tiempo)
     * - social_links: conversión desde JSON a array nativo de PHP
     */
    protected $casts = [
        'birth_date' => 'date',
        'social_links' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}