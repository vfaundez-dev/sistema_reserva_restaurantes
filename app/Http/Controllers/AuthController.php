<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller {
    
    /**
     * @OA\Post(
     *     path="/api/v1/auth/login",
     *     summary="Login user",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="admin@reservation.com"),
     *             @OA\Property(property="password", type="string", example="asdf1234")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful, returns JWT token",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized - Invalid credentials",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function login(Request $request) {
        try {
            
            $credentials = $request->only('email', 'password');

            if (!$token = JWTAuth::attempt($credentials))
                return ApiResponse::error(null, 'Invalid credentials', 401);

            return ApiResponse::success( $this->getResponseToken($token) );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Error logged in');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/register",
     *     summary="Register a new user",
     *     operationId="registerUser",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name","email", "password", "role"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="user@reservation.com"),
     *             @OA\Property(property="password", type="string", example="asdf1234"),
     *             @OA\Property(property="role", type="string", example="receptionist")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User registered successful",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function register(StoreUserRequest $request) {
        try {

            $userRepository = new UserRepository;
            $newUser = $userRepository->create( $request->validated() );
            return ApiResponse::success($newUser, 'User registered successfully');

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Failed to register user');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to register user');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/me",
     *     summary="Get authenticated user",
     *     operationId="getAuthenticatedUser",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Authenticated user data",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function me() {
        try {

            $user = Auth::user();
            if (!$user) return ApiResponse::error(null, 'Unauthenticated', 401);

            return ApiResponse::success( new UserResource($user) );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/refresh",
     *     summary="Refresh JWT token",
     *     operationId="refreshToken",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function refresh() {
        try {

            $user = auth()->userOrFail();
            $refreshToken = auth()->refresh();
            return ApiResponse::success( $this->getResponseToken($refreshToken) );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/auth/logout",
     *     summary="Logout user",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Successfully logged out",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function logout() {
        try {

            Auth::logout();
            return ApiResponse::success(null, 'Successfully logged out');

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
