<?php

namespace App\Swagger\Responses;

/**
 * @OA\Response(
 *     response="UserSuccess",
 *     description="Successful user operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/User")
 *         )
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="UserSuccessId",
 *     description="Successful user operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(property="data", type="object", ref="#/components/schemas/User")
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="UserInvalidRequest",
 *     description="Invalid request data",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Invalid request"),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="field", type="string", example="email"),
 *                  @OA\Property(property="message", type="string", example="The email field is required.")
 *             )
 *         )
 *     )
 * ),
 * 
*/
class UserResponses {}