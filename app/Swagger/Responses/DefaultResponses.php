<?php

namespace App\Swagger\Responses;

/**
  * @OA\Response(
  *     response="NotFoundError",
  *     description="Reservation not found",
  *     @OA\JsonContent(ref="#/components/schemas/NotFoundResponse")
  * ),
  * 
  * @OA\Response(
  *     response="UnauthenticatedError",
  *     description="Unauthenticated user",
  *     @OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")
  * ),
  * 
  * @OA\Response(
  *     response="UnauthorizedError",
  *     description="Unauthorized action",
  *     @OA\JsonContent(ref="#/components/schemas/UnauthorizedResponse")
  * ),
  * 
  * @OA\Response(
  *     response="ServerError",
  *     description="Internal server error",
  *     @OA\JsonContent(ref="#/components/schemas/ServerErrorResponse")
  * )
  *
*/
class DefaultResponses {}