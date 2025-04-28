<?php

namespace App\Swagger\Schemas;

  /**
  * @OA\Schema(
  *     schema="Customer",
  *     type="object",
  *     @OA\Property(property="id", type="integer", example=1),
  *     @OA\Property(property="name", type="string", example="John Doe"),
  *     @OA\Property(property="email", type="string", example="john@mail.com"),
  *     @OA\Property(property="phone", type="string", example="+56912345678"),
  *     @OA\Property(property="registration_date", type="string", format="date-time", example="2024-01-01T12:00:00Z")
  * ),
  */
  class CustomerSchema{}