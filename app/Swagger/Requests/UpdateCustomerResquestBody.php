<?php

namespace App\Swagger\Requests;

/**
 * @OA\RequestBody(
 *     request="UpdateCustomerRequest",
 *     description="Data to update a customer",
 *     required=true,
 *     @OA\JsonContent(
 *         @OA\Property(property="name", type="string", example="John Doe"),
 *         @OA\Property(property="email", type="string", format="email", example="johndoe@example.com"),
 *         @OA\Property(property="phone", type="string", example="+123456789"),
 *         @OA\Property(property="registrationDate", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 *     )
 * )
*/
class UpdateCustomerResquestBody{}