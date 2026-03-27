<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ApiResponse;
use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Resources\EnrollmentResource;
use App\Models\Enrolment;
use App\Models\Student;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Menampilkan daftar kursus yang sudah diikuti oleh siswa yang sedang login.
     * (Display a listing of courses joined by the logged-in student.)
     */
    public function index(Request $request)
    {
        $userId = $request->user()->id;
        $student = Student::where('user_id', $userId)->first();

        if (!$student) {
            return ApiResponse::ErrorResponse("Data siswa tidak ditemukan.", 404);
        }

        // Mengambil data pendaftaran beserta relasi kursusnya
        $enrollments = Enrolment::with('course')
            ->where('student_id', $student->id)
            ->get();

        // Menggunakan EnrollmentResource::collection untuk mengubah data menjadi JSON
        return ApiResponse::SuccessResponse(
            'enrollments', 
            EnrollmentResource::collection($enrollments), 
            200
        );
    }

    /**
     * Mendaftarkan siswa ke kursus baru.
     * (Enroll student into a new course.)
     */
    public function store(StoreEnrollmentRequest $request)
    {
        // Mendapatkan ID user yang sedang login dari token Sanctum
        $userId = $request->user()->id;

        // Mencari data student berdasarkan user_id
        $student = Student::where('user_id', $userId)->first();

        // Jika user bukan student, berikan respon error
        if (!$student) {
            return ApiResponse::ErrorResponse("Hanya Siswa Yang Dapat Mendaftar Kursus", 403);
        }

        // Cek apakah siswa sudah terdaftar di kursus ini sebelumnya
        $isEnrolled = Enrolment::where('student_id', $student->id) 
                                ->where('course_id', $request->course_id)
                                ->first();

        if ($isEnrolled) {
            return ApiResponse::ErrorResponse("Anda Sudah Mendaftar Kursus ini!", 400);
        }

        // Membuat data pendaftaran baru menggunakan data hasil validasi dari StoreEnrollmentRequest
        $enrollment = Enrolment::create([
            'student_id' => $student->id, 
            'course_id' => $request->course_id,
            'notes' => $request->notes,
        ]);

        // Memberikan respon sukses dengan data pendaftaran yang baru dibuat
        return ApiResponse::MessageResponse(
            "Pendaftaran Kursus Berhasil", 200
        );
    }
}
