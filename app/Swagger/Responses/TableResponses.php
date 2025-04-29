<?php

namespace App\Swagger\Responses;

/**
 * @OA\Response(
 *     response="TableSuccess",
 *     description="Successful table operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Table")
 *         )
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="TableSuccessId",
 *     description="Successful table operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(property="data", type="object", ref="#/components/schemas/Table")
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="TableInvalidRequest",
 *     description="Invalid request data",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Invalid request"),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="field", type="string", example="status"),
 *                  @OA\Property(property="message", type="string", example="The status field is required.")
 *             )
 *         )
 *     )
 * ),
 * 
*/
class TableResponses {}