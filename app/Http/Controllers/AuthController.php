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

    public function register(StoreUserRequest $request) {
        try {

            $userRepository = new UserRepository;
            $newUser = $userRepository->create( $request->validated() );
            return ApiResponse::success($newUser, 'User registered successfully');

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Error logged in');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to register user');
        }
    }

    public function me() {
        try {

            $user = Auth::user();
            if (!$user) return ApiResponse::error(null, 'Unauthenticated', 401);

            return ApiResponse::success( new UserResource($user) );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', 401);
        }
    }

    public function refresh() {
        try {

            $user = auth()->userOrFail();
            $refreshToken = auth()->refresh();
            return ApiResponse::success( $this->getResponseToken($refreshToken) );

        } catch (\Tymon\JWTAuth\Exceptions\UserNotDefinedException $e) {
            return ApiResponse::exception($e, 'Unauthenticated', 401);
        }
    }

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
