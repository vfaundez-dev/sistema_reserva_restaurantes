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
 * )
 * 
 */
class SwaggerDoc {}
