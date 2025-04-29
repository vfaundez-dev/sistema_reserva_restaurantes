<?php

namespace App\Swagger\Requests;

/**
 * @OA\RequestBody(
 *     request="UpdateUserRequest",
 *     description="Data required to update a user",
 *     required=true,
 *     content={
 *         @OA\MediaType(
 *             mediaType="application/json",
 *             @OA\Schema(
 *                 required={"name", "email", "password", "role"},
 *                 type="object",
 *                 @OA\Property(property="name", type="string", example="John Doe"),
 *                 @OA\Property(property="email", type="string", example="john@mail.com"),
 *                 @OA\Property(property="password", type="string", example="Password_123"),
 *                 @OA\Property(property="role", type="string", example="receptionist"),
 *             )
 *         )
 *     }
 * )
*/
class UpdateUserRequestBody {}