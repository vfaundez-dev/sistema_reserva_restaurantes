<?php

namespace App\Swagger\Responses;

/**
 * @OA\Response(
 *     response="ReservationSuccess",
 *     description="Successful reservation operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/Reservation")
 *         )
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="ReservationSuccessId",
 *     description="Successful customer operation",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example=""),
 *         @OA\Property(property="data", type="object", ref="#/components/schemas/Customer")
 *     )
 * ),
 * 
 * @OA\Response(
 *     response="ReservationInvalidRequest",
 *     description="Invalid request data",
 *     @OA\JsonContent(
 *         @OA\Property(property="status", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Invalid request"),
 *         @OA\Property(
 *             property="data",
 *             type="array",
 *             @OA\Items(
 *                  type="object",
 *                  @OA\Property(property="field", type="string", example="name"),
 *                  @OA\Property(property="message", type="string", example="The name field is required.")
 *             )
 *         )
 *     )
 * ),
 * 
 *
*/
class ReservationResponses {}