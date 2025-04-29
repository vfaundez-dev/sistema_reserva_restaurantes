<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="Endpoints for authentication using JWT"
 * )
 */
class AuthController extends Controller {
    
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     tags={"Authentication"},
     *     summary="User login",
     *     operationId="loginUser",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email", example="admin@reservation.com"),
     *             @OA\Property(property="password", type="string", format="password", example="asdf1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful login",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logged in successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK..."),
     *                 @OA\Property(property="token_type", type="string", example="bearer"),
     *                 @OA\Property(property="expired", type="string", format="date-time", example="2025-05-01 12:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, description="Invalid credentials"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function login(Request $request) {
        try {
            
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials))
                return ApiResponse::error(null, 'Invalid credentials', Response::HTTP_UNAUTHORIZED);

            return ApiResponse::success( $this->getResponseToken($token), 'Logged in successfully', Response::HTTP_OK );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Error logged in');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     tags={"Authentication"},
     *     summary="User registration",
     *     operationId="registerUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreUserRequest"),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User registered successfully"),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *        )
     *     ),
     *     @OA\Response(response=400, ref="#/components/responses/UserInvalidRequest"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=422, description="Failed to register user"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function register(StoreUserRequest $request) {
        try {

            $userRepository = new UserRepository;
            $newUser = $userRepository->create( $request->validated() );
            return ApiResponse::success($newUser, 'User registered successfully', Response::HTTP_CREATED);

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Failed to register user');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to register user');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/me",
     *     tags={"Authentication"},
     *     summary="Get authenticated user",
     *     operationId="getAuthenticatedUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example=""),
     *             @OA\Property(property="data", type="object", ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function me() {
        try {

            $user = Auth::user();
            if (!$user) return ApiResponse::error(null, 'Unauthenticated', Response::HTTP_UNAUTHORIZED);

            return ApiResponse::success( new UserResource($user), '', Response::HTTP_OK );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     tags={"Authentication"},
     *     summary="Refresh JWT token",
     *     operationId="refreshToken",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Token refreshed successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJK..."),
     *                 @OA\Property(property="token_type", type="string", example="bearer"),
     *                 @OA\Property(property="expired", type="string", format="date-time", example="2025-05-01 12:00:00")
     *             )
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function refresh() {
        try {

            $user = auth()->userOrFail();
            $refreshToken = auth()->refresh();
            return ApiResponse::success( $this->getResponseToken($refreshToken), 'Token refreshed successfully', Response::HTTP_OK );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     tags={"Authentication"},
     *     summary="User logout",
     *     operationId="logoutUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Successfully logged out"),
     *             @OA\Property(property="data", type="string", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function logout() {
        try {

            Auth::logout();
            return ApiResponse::success(null, 'Successfully logged out', Response::HTTP_OK);

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Error logged out');
        }
    }

    private function expiredToken() {
        $expiresIn = auth()->factory()->getTTL() * 60;
        return \Carbon\Carbon::now()->addSeconds($expiresIn)->toDateTimeString();
    }

    private function getResponseToken($token) {
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expired' => $this->expiredToken(),
        ];
    }

}
