<?php

namespace App\Swagger\Schemas;

/**
  * @OA\Schema(
  *     schema="Table",
  *     type="object",
  *     @OA\Property(property="id", type="integer", example=1),
  *     @OA\Property(property="is_available", type="boolean", example=true),
  *     @OA\Property(property="capacity", type="integer", example=4),
  *     @OA\Property(property="location", type="string", example="indoor")
  * ),
*/
class TableSchema {}