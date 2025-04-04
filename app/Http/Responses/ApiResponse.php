<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;
use Throwable;

class ApiResponse {

  public static function success($data = null, string $message = '', int $code = Response::HTTP_OK): JsonResponse {
    $response = [
      'success' => true,
      'message' => !empty($message) ? $message : null,
      'data' => $data
    ];

    return response()->json($response, $code);
  }

  public static function error($data = null, $message = 'Operation failed', int $code = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse {
    $response = [
      'success' => false,
      'message' => $message,
      'data' => $data
    ];

    return response()->json($response, $code);
  }

  public static function exception(
    Throwable $e, string $message = 'Operation failed', int $code = Response::HTTP_INTERNAL_SERVER_ERROR
  ): JsonResponse {

    Log::error("API Error: {$e->getMessage()}", [
      'exception' => get_class($e),
      'file' => $e->getFile(),
      'line' => $e->getLine(),
      'trace' => $e->getTraceAsString()
    ]);

    return response()->json([
      'success' => false,
      'message' => $message
    ], $code);
    
  }

}
