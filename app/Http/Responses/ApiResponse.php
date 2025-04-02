<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponse {

  public static function sendResponse($data , string $message ,$code = 200): JsonResponse {
    $response = [
      'success' => true,
      'data'    => $data
    ];

    if(!empty($message)) $response['message'] = $message;
    return response()->json($response, $code);
  }

  public static function error($e, $message ="Something went wrong! Process not completed"){
    Log::info($e);
    throw new HttpResponseException(
      response()->json( ["message"=> $message], 500 )
    );
  }

}