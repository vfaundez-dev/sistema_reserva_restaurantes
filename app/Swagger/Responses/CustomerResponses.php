<?php

namespace App\Swagger\Responses;

/**
 * @OA\Response(
 *     response="CustomerSuccess",
 *     description="Successful customer operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Customer")
 *         )
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="InvalidRequest",
 *     description="Invalid request data",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Invalid request"),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="field", type="string", example="email", description="Field with validation error."),
 *                  @OA\Property(property="message", type="string", example="The email field is required.", description="Validation error message.")
 *             )
 *         )
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="NotFoundError",
 *     description="Customer not found",
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
 * ),
 *
*/
class CustomerResponses {}