<?php

namespace App\Swagger\Parameters;

/**
 * @OA\Parameter(
 *     parameter="ReservationSortByParam",
 *     name="sort_by",
 *     in="query",
 *     description="Field to sort reservations by.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"id", "number_of_peoples", "status", "notes", "customer_id", "user_id"},
 *         default="id"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="ReservationIncludeParam",
 *     name="include",
 *     in="query",
 *     description="Comma-separated list of relationships to include.",
 *     required=false,
 *     @OA\Schema(type="string", example="customer,tables,user")
 * )
 *
*/
class ReservationFilterParameters {}