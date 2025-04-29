<?php

namespace App\Swagger\Parameters;

/**
 * @OA\Parameter(
 *     parameter="SearchParam",
 *     name="search",
 *     in="query",
 *     description="Search term for textual filtering.",
 *     required=false,
 *     @OA\Schema(type="string")
 * )
 *
 * @OA\Parameter(
 *     parameter="SortByParam",
 *     name="sort_by",
 *     in="query",
 *     description="Field to sort by.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"id", "name", "email", "date"},
 *         default="id"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="SortDirParam",
 *     name="sort_dir",
 *     in="query",
 *     description="Sort direction.",
 *     required=false,
 *     @OA\Schema(
 *         type="string",
 *         enum={"asc", "desc"},
 *         default="asc"
 *     )
 * )
 *
 * @OA\Parameter(
 *     parameter="DateFromParam",
 *     name="date_from",
 *     in="query",
 *     description="Filter records from this date (inclusive). Format: YYYY-MM-DD",
 *     required=false,
 *     @OA\Schema(type="string", format="date")
 * )
 *
 * @OA\Parameter(
 *     parameter="DateToParam",
 *     name="date_to",
 *     in="query",
 *     description="Filter records up to this date (inclusive). Format: YYYY-MM-DD",
 *     required=false,
 *     @OA\Schema(type="string", format="date")
 * )
 *
 * @OA\Parameter(
 *     parameter="DateFieldParam",
 *     name="date_field",
 *     in="query",
 *     description="Field to apply the date filter on.",
 *     required=false,
 *     @OA\Schema(type="string", default="created_at")
 * )
 *
 * @OA\Parameter(
 *     parameter="IncludeParam",
 *     name="include",
 *     in="query",
 *     description="Comma-separated list of relationships to include.",
 *     required=false,
 *     @OA\Schema(type="string", example="reservations,notes")
 * )
 *
 * @OA\Parameter(
 *     parameter="PageParam",
 *     name="page",
 *     in="query",
 *     description="Current page number.",
 *     required=false,
 *     @OA\Schema(type="integer", default=1)
 * )
 *
 * @OA\Parameter(
 *     parameter="PerPageParam",
 *     name="per_page",
 *     in="query",
 *     description="Number of records per page.",
 *     required=false,
 *     @OA\Schema(type="integer", default=15)
 * )
 */
class FilterParameters {}
