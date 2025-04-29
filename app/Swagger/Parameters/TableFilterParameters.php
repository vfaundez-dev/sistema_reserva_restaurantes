<?php

namespace App\Swagger\Parameters;

/**
 * @OA\Parameter(
 *     parameter="TableSortByParam",
 *     name="sort_by",
 *     in="query",
 *     description="Field to sort tables by.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"id", "is_available", "capacity", "location"},
 *         default="id"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="TableIncludeParam",
 *     name="include",
 *     in="query",
 *     description="Comma-separated list of relationships to include.",
 *     required=false,
 *     @OA\Schema(type="string", example="reservations")
 * )
 *
*/
class TableFilterParameters {}