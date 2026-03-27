<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseController extends Controller
{
    /**
     * Menampilkan daftar semua kursus.
     * (Display a listing of the courses.)
     */
    public function index(): JsonResponse
    {
        $courses = Course::all();

        // Menggunakan helper ApiResponse untuk mengembalikan data kursus
        return ApiResponse::SuccessResponse(
            'courses', 
            CourseResource::collection($courses), 
            200
        );
    }

    /**
     * Display the specified course.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $course = Course::with('materials')->findOrFail($id);

       return ApiResponse::SuccessResponse('course', new CourseResource($course), 200);
    }
}