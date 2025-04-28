<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="Sistema de Reservas de Restaurantes",
 *     version="1.0.0",
 *     description="API para la gestión de clientes, mesas y reservas.",
 *     @OA\Contact(
 *         name="Vladimir Faundez",
 *         email="v.faundezh@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Creative Commons Attribution-NonCommercial-NoDerivatives 4.0 International",
 *         url="https://creativecommons.org/licenses/by-nc-nd/4.0/legalcode"
 *     )
 * ),
 * 
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="Servidor principal de la API"
 * ),
 * 
 * @OA\SecurityScheme(
 *     securityScheme="BearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="JWT Authorization header usando el esquema Bearer."
 * )
*/
class SwaggerDoc {}
