<?php

namespace App\Traits;
use Illuminate\Http\Response;

trait ApiResponse
{
    public function successResponse($message, $statusCode = Response::HTTP_OK)
    {
        return response()->json($message, $statusCode);
    }

    public function errorResponse($errorMessage, $statusCode)
    {
        return response()->json(['error' => $errorMessage, 'error_code' => $statusCode], $statusCode);
    }

}
