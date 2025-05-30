<?php

namespace App\Swagger\Requests;

/**
 * @OA\RequestBody(
 *     request="StoreTableRequest",
 *     description="Data required to store a table",
 *     required=true,
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"is_available", "capacity", "location"},
 *                 type="object",
 *                 @OA\Property(property="is_available", type="boolean", example=true),
 *                 @OA\Property(property="capacity", type="integer", example=4),
 *                 @OA\Property(property="location", type="string", example="indoor")
 *             )
 *         )
 *     }
 * )
*/
class StoreTableRequestBody {}