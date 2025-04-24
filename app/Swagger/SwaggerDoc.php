<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Sistema de Reservas de Restaurantes",
 *     version="1.0.0",
 *     description="API para la gestión de clientes, mesas y reservas.",
 *     @OA\Contact(
 *         name="Vladimir Faundez",
 *         email="v.faundezh@gmail.com",
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor API"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * ),
 * 
 *  @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Operation successful"),
 *     @OA\Property(property="data", type="object")
 * )
 * 
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="status", type="boolean", example=false),
 *     @OA\Property(property="message", type="string", example="Operation failed"),
 *     @OA\Property(property="data", type="string", example=null)
 * ),
 * 
 * @OA\Schema(
 *     schema="Customer",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", example="john@mail.com"),
 *     @OA\Property(property="phone", type="string", example="+56912345678"),
 *     @OA\Property(property="registration_date", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * ),
 * 
 * @OA\Schema(
 *     schema="Table",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="is_available", type="boolean", example=true),
 *     @OA\Property(property="capacity", type="integer", example=4),
 *     @OA\Property(property="location", type="string", example="indoor"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * ),
 * 
 * @OA\Schema(
 *     schema="Reservation",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="reservation_date", type="string", format="date", example="2024-05-15"),
 *     @OA\Property(property="reservation_time", type="string", format="time", example="20:00:00"),
 *     @OA\Property(property="number_of_peoples", type="integer", example=10),
 *     @OA\Property(property="status", type="string", example="pending"),
 *     @OA\Property(property="notes", type="string", example="Table near the window"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * ),
 * 
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Administrador"),
 *     @OA\Property(property="email", type="string", example="admin@reservation.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-01-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-01-01T12:00:00Z")
 * )
 * 
 */
class SwaggerDoc {}
