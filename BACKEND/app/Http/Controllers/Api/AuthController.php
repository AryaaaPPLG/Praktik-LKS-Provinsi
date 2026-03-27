<?php

namespace App\Http\Controllers\Api;

use App\Http\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        // dd($request->all());
        // Cari user berdasarkan email [cite: 964]
        $user = User::where('email', $request->email)->first(); 

        // Cek kalau user gak ada ATAU password salah [cite: 965]
        if(!$user || !Hash::check($request->password, $user->password)) { 
            return ApiResponse::ErrorResponse("Email atau Password salah", 401); 
        }

        // Bikin token Sanctum [cite: 969]
        $token = $user->createToken('auth_token')->plainTextToken; 

        // Siapin data balikan [cite: 990]
        $data = [
            "name"  => $user->name, 
            "email" => $user->email, 
            "token" => $token 
        ];

        return ApiResponse::SuccessResponse('data', $data, 200); 
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return ApiResponse::SuccessResponse("Logout Berhasil");
    }
}
