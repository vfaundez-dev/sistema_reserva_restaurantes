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
      'data' => $data
    ];

    if (!empty($message)) {
      $response['message'] = $message;
    }

    return response()->json($response, $code);
  }

  public static function error(
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
