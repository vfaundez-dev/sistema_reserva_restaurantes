<?php

namespace App\Swagger\Schemas;

/**
  * @OA\Schema(
  *     schema="User",
  *     type="object",
  *     @OA\Property(property="id", type="integer", example=1),
  *     @OA\Property(property="name", type="string", example="John Doe"),
  *     @OA\Property(property="email", type="string", example="john@mail.com"),
  *     @OA\Property(property="roles", type="array", @OA\Items(type="string", example="recepcionist"))
  * ),
*/
class UserSchema {}