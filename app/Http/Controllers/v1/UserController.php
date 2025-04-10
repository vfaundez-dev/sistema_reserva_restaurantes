<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller {

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }
    
    public function index() {
        try {
            return ApiResponse::success( $this->userRepository->getAll() );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve users');
        }
    }

    public function store(StoreUserRequest $request) {
        try {

            $newUser = $this->userRepository->create( $request->validated() );
            return ApiResponse::success( $newUser, 'User created successfully' );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to create user');
        }
    }

    public function show(User $user) {
        try {
            return ApiResponse::success( $this->userRepository->getById($user) );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve user');
        }
    }

    public function update(UpdateUserRequest $request, User $user) {
        try {

            if ($user->id == 1) return ApiResponse::error(null, 'Not authorized to modify o deleted Admin user', 403);
            $updateUser = $this->userRepository->update( $request->validated(), $user );
            return ApiResponse::success( $updateUser, 'User updated successfully' );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update user');
        }
    }

    public function destroy(User $user) {
        try {

            if ($user->id == 1) return ApiResponse::error(null, 'Not authorized to modify o deleted Admin user', 403);
            $this->userRepository->destroy($user);
            return ApiResponse::success(null, 'User deleted successfully');

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete user');
        }
    }

    public function getByEmail(Request $request) {
        try {

            $validData = $request->validate([
                'email' => 'required|email',
            ]);

            $userEmail = $this->userRepository->getByEmail( $validData['email'] );
            if (!$userEmail) return ApiResponse::error(null, 'User not found', 404);
            return ApiResponse::success( $userEmail );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve user by email');
        }
    }

    public function changePassword(UpdateUserRequest $request, User $user) {
        try {

            if (!$request->password) return ApiResponse::error(null, 'Password is required', 422);
            $this->userRepository->changePassword($user, $request->password);
            return ApiResponse::success(null, 'Password changed successfully');
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to change password');
        }
    }

}
