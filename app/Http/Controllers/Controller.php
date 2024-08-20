<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function responseWithError(string $message, string $code, int $statusCode = 400)
    {
        return response()->json([
            'error_code' => $code,
            'message' => $message
        ], $statusCode);
    }
}
