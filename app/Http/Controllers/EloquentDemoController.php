<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\User;

/**
 * EloquentDemoController
 *
 * Demuestra el uso de Eloquent ORM con relaciones, filtros, ordenamiento y eager loading.
 * Justifica el cumplimiento de los requisitos del laboratorio de modelado con Laravel y Eloquent.
 *
 * Requisitos cubiertos:
 * - 10 tablas con migraciones up() y down()
 * - 1 modelo Eloquent por tabla con $fillable y $casts
 * - 5 relaciones bidireccionales entre modelos
 * - 5 consultas Eloquent con relaciones, filtros y ordenamiento
 * - 1 consulta con eager loading justificando N+1
 */
class EloquentDemoController extends Controller
{
    public function __invoke()
    {
        /**
         * CONSULTA 1: Relaciones anidadas con eager loading + ordenamiento
         * Demuestra: BelongsTo (relaciones N:1), nested relationships, latest()
         * - Course->category (N:1)
         * - Course->level (N:1)
         * - Course->teacher (N:1)
         * - teacher->profile (1:1)
         * Patrón: with(['category', 'level', 'teacher.profile'])
         */
        $courses = Course::with(['category', 'level', 'teacher.profile'])
            ->latest()
            ->take(5)
            ->get();

        /**
         * CONSULTA 2: Eager loading de relaciones 1:N con agregación (withCount) + ordenamiento
         * Demuestra: HasMany (relaciones 1:N), BelongsToMany, conteo de relaciones, orderByDesc()
         * - Course->lessons (1:N)
         * - Course->tags (N:N)
         * - Course->enrollments (1:N con conteo)
         * EVITA PROBLEMA N+1: Sin eager loading, cada curso requeriría una query adicional
         * para contar enrollments. Con withCount(), se realiza en una sola query.
         * Patrón: with(['lessons', 'tags'])->withCount('enrollments')
         */
        $popularCourses = Course::with(['lessons', 'tags'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->get();

        /**
         * CONSULTA 3: whereHas() con filtro + ordenamiento
         * Demuestra: whereHas() para filtrar por relación N:N (tags)
         * - Filtra cursos que tengan la etiqueta 'laravel'
         * - Ordena por título
         * Patrón: whereHas('tags', function($query) { $query->where(...) })->orderBy()
         */
        $coursesByTag = Course::whereHas('tags', function ($query) {
            $query->where('slug', 'laravel');
        })
            ->orderBy('title')
            ->get();

        /**
         * CONSULTA 4: withCount() de relación + filtro where() + ordenamiento
         * Demuestra: Conteo de relaciones 1:N, filtro por valor de columna
         * - Filtra users por rol 'student'
         * - Cuenta cuántas inscripciones tiene cada estudiante
         * - Ordena por número de inscripciones
         * Patrón: withCount('enrollments')->where('role', 'student')->orderByDesc()
         */
        $students = User::withCount('enrollments')
            ->where('role', 'student')
            ->orderByDesc('enrollments_count')
            ->get();

        /**
         * CONSULTA 5: Eager loading de múltiples relaciones + filtro comparativo + latest()
         * Demuestra: Eager loading bidireccional (Review->user, Review->course)
         * - Filtra reseñas con rating >= 4 (filtro por comparación numérica)
         * - Carga relaciones user y course para evitar N+1
         * - Ordena por más recientes
         * Patrón: with(['user', 'course'])->where('rating', '>=', 4)->latest()
         */
        $recentReviews = Review::with(['user', 'course'])
            ->where('rating', '>=', 4)
            ->latest()
            ->get();

        /**
         * CONSULTA 6: whereHas() con relación anidada profunda + ordenamiento
         * Demuestra: whereHas() anidado para filtrar por relación 2 niveles de profundidad
         * - Lesson->course (N:1)
         * - Course->level (N:1)
         * - Filtra lecciones de cursos con nivel 'basico'
         * - Ordena por posición dentro del curso
         * Patrón: whereHas('course', whereHas('level', where(...)))->orderBy()
         */
        $introLessons = Lesson::whereHas('course', function ($query) {
            $query->whereHas('level', function ($levelQuery) {
                $levelQuery->where('slug', 'basico');
            });
        })
            ->orderBy('position')
            ->get();

        return response()->json([
            'courses' => $courses,
            'popularCourses' => $popularCourses,
            'coursesByTag' => $coursesByTag,
            'students' => $students,
            'recentReviews' => $recentReviews,
            'introLessons' => $introLessons,
        ]);
    }
}