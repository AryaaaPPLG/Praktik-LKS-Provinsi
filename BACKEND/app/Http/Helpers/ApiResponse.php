<?php 

namespace App\Http\Helpers;

class ApiResponse
{
   
    public static function SuccessResponse($namaData = 'data', $data = null, $code = 200)
    {
        return response()->json([
            $namaData => $data,
        ], $code);
    }


    public static function MessageResponse($message, $code = 200)
    {
        return response()->json([
            "message" => $message,
        ], $code);
    }

    
    public static function ErrorResponse($message, $code = 400)
    {
        return response()->json([
            "message" => $message,
        ], $code);
    }

}