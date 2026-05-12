<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Review;
use App\Models\User;

class EloquentDemoController extends Controller
{
    public function __invoke()
    {
        $courses = Course::with(['category', 'level', 'teacher.profile'])
            ->latest()
            ->take(5)
            ->get();

        // Se usa eager loading aquí para evitar el problema N+1 al cargar relaciones de cada curso.
        $popularCourses = Course::with(['lessons', 'tags'])
            ->withCount('enrollments')
            ->orderByDesc('enrollments_count')
            ->get();

        $coursesByTag = Course::whereHas('tags', function ($query) {
            $query->where('slug', 'laravel');
        })
            ->orderBy('title')
            ->get();

        $students = User::withCount('enrollments')
            ->where('role', 'student')
            ->orderByDesc('enrollments_count')
            ->get();

        $recentReviews = Review::with(['user', 'course'])
            ->where('rating', '>=', 4)
            ->latest()
            ->get();

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