<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    /**
     * Send a successful JSON response.
     *
     * @param mixed $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function successResponse($data = null, $message = 'Success', $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $statusCode);
    }

    /**
     * Send an error JSON response.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    public function errorResponse($message = 'An error occurred', $statusCode = 400): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}