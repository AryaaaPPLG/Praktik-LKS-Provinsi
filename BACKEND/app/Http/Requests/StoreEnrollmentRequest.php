<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     */
    public function authorize(): bool
    {
        // Izinkan semua pengguna yang terautentikasi (logika tambahan bisa ditaruh di sini)
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id', 
            'notes' => 'nullable|string', 
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'course_id.required' => 'ID Kursus wajib diisi.',
            'course_id.exists' => 'Kursus tidak ditemukan.',
            'notes.string' => 'Catatan harus berupa teks.',
        ];
    }
}
