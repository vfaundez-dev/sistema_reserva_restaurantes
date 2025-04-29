<?php

namespace App\Swagger\Schemas;

/**
  * @OA\Schema(
  *     schema="Reservation",
  *     type="object",
  *     @OA\Property(property="id", type="integer", example=1),
  *     @OA\Property(property="reservation_date", type="string", format="date", example="2024-01-01"),
  *     @OA\Property(property="reservation_time", type="string", format="time", example="12:00"),
  *     @OA\Property(property="number_of_people", type="integer", example=4),
  *     @OA\Property(property="status", type="string", example="confirmed"),
  *     @OA\Property(property="notes", type="string", example="Family dinner"),
  *     @OA\Property(property="customer_id", type="integer", example=3),
  *     @OA\Property(property="user_id", type="integer", example=2)
  * ),
*/
class ReservationSchema {}