<?php

namespace App\Swagger;

/**
 * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Operation successful"),
 *     @OA\Property(property="data", type="object", nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Operation failed"),
 *     @OA\Property(property="data", type="string", example=null, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="UnauthenticatedResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Unauthenticated"),
 *     @OA\Property(property="data", type="string", example=null, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="NotFoundResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Resource not found"),
 *     @OA\Property(property="data", type="string", example=null, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="UnauthorizedResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Unauthorized"),
 *     @OA\Property(property="data", type="string", example=null, nullable=true)
 * )
 * 
 * @OA\Schema(
 *     schema="InvalidRequestResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Invalid request"),
 *     @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(
 *             type="object",
 *             @OA\Property(property="field", type="string", example="email"),
 *             @OA\Property(property="message", type="string", example="The email field is required.")
 *         )
 *     )
 * )
 * 
 * @OA\Schema(
 *     schema="ServerErrorResponse",
 *     type="object",
 *     required={"status", "message", "data"},
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Server error"),
 *     @OA\Property(
 *        property="data",
 *        type="array",
 *        @OA\Items(
 *            type="object",
 *            @OA\Property(property="error", type="string", example="Internal server error")
 *        )
 *    )
 * )
 */
class SwaggerResponses {}
