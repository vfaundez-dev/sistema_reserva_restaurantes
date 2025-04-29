<?php

namespace App\Swagger\Parameters;

/**
 * @OA\Parameter(
 *     parameter="CustomerSortByParam",
 *     name="sort_by",
 *     in="query",
 *     description="Field to sort customers by.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"id", "name", "email", "phone"},
 *         default="id"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="CustomerIncludeParam",
 *     name="include",
 *     in="query",
 *     description="Comma-separated list of relationships to include.",
 *     required=false,
 *     @OA\Schema(type="string", example="reservations")
 * )
 *
*/
class CustomerFilterParameters {}