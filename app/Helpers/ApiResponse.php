<?php

namespace App\Helpers;

class ApiResponse{

    public static function success($data, $code = 200)
    {
        return response()->json([
            'code' => $code,
            'status' => 'success',
            'data' => $data
        ], $code);
    }

    public static function error($message, $code = 500)
    {
        return response()->json([
            'code' => $code,
            'status' => 'error',
            'message' => $message
        ], $code);
    }
}
