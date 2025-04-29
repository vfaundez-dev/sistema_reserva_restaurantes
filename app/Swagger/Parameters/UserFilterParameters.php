<?php

namespace App\Swagger\Parameters;

/**
 * @OA\Parameter(
 *     parameter="UserSortByParam",
 *     name="sort_by",
 *     in="query",
 *     description="Field to sort users by.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"id", "name", "email"},
 *         default="id"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="UserIncludeParam",
 *     name="include",
 *     in="query",
 *     description="Comma-separated list of relationships to include.",
 *     required=false,
 *     @OA\Schema(type="string", example="reservations")
 * )
 *
*/
class UserFilterParameters {}