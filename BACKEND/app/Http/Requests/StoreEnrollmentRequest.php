<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentRequest extends FormRequest
{
    /**
     * Menentukan apakah pengguna diizinkan untuk membuat permintaan ini.
     * (Determine if the user is authorized to make this request.)
     */
    public function authorize(): bool
    {
        // Izinkan semua pengguna yang terautentikasi (logika tambahan bisa ditaruh di sini)
        return true;
    }

    /**
     * Mendapatkan aturan validasi yang berlaku untuk permintaan ini.
     * (Get the validation rules that apply to the request.)
     */
    public function rules(): array
    {
        return [
            'course_id' => 'required|exists:courses,id', // Harus ada di tabel courses
            'notes' => 'nullable|string', // Opsional, harus berupa string jika ada
        ];
    }

    /**
     * Kustomisasi pesan kesalahan validasi dalam Bahasa Indonesia.
     * (Customizing validation error messages in Indonesian.)
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
