<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Throwable;

class UserController extends Controller {

    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository) {
        $this->userRepository = $userRepository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/users",
     *     tags={"User"},
     *     summary="Get all users",
     *     description="Retrieve a list of all users",
     *     operationId="getAllUsers",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(ref="#/components/parameters/SearchParam"),
     *     @OA\Parameter(ref="#/components/parameters/UserSortByParam"),
     *     @OA\Parameter(ref="#/components/parameters/SortDirParam"),
     *     @OA\Parameter(ref="#/components/parameters/DateFromParam"),
     *     @OA\Parameter(ref="#/components/parameters/DateToParam"),
     *     @OA\Parameter(ref="#/components/parameters/DateFieldParam"),
     *     @OA\Parameter(ref="#/components/parameters/UserIncludeParam"),
     *     @OA\Parameter(ref="#/components/parameters/PageParam"),
     *     @OA\Parameter(ref="#/components/parameters/PerPageParam"),
     *     @OA\Response(response=200, ref="#/components/responses/UserSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function index() {
        try {
            return ApiResponse::success( $this->userRepository->getAll(), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve users');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users",
     *     tags={"User"},
     *     summary="Create a new user",
     *     description="Store a new user in the system",
     *     operationId="createUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreUserRequest"),
     *     @OA\Response(response=201, ref="#/components/responses/UserSuccessId"),
     *     @OA\Response(response=400, ref="#/components/responses/UserInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function store(StoreUserRequest $request) {
        try {

            $newUser = $this->userRepository->create( $request->validated() );
            return ApiResponse::success( $newUser, 'User created successfully', Response::HTTP_CREATED );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to create user');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{user}",
     *     tags={"User"},
     *     summary="Get a user by ID",
     *     description="Retrieve a user by their ID",
     *     operationId="getUserById",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/UserIncludeParam"),
     *     @OA\Response(response=200, ref="#/components/responses/UserSuccessId"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function show(User $user) {
        try {
            return ApiResponse::success( $this->userRepository->getById($user), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve user');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/users/{user}",
     *     tags={"User"},
     *     summary="Update a user",
     *     description="Update an existing user",
     *     operationId="updateUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateUserRequest"),
     *     @OA\Response(response=200, ref="#/components/responses/UserSuccessId"),
     *     @OA\Response(response=400, ref="#/components/responses/UserInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     * )
    */
    public function update(UpdateUserRequest $request, User $user) {
        try {

            if ($user->id == 1) return ApiResponse::error(null, 'Not authorized to modify o deleted Admin user', Response::HTTP_FORBIDDEN);
            $updateUser = $this->userRepository->update( $request->validated(), $user );
            return ApiResponse::success( $updateUser, 'User updated successfully', Response::HTTP_OK );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update user');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/users/{user}",
     *     tags={"User"},
     *     summary="Delete a user",
     *     description="Delete a user by their ID",
     *     operationId="deleteUser",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="User deleted successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function destroy(User $user) {
        try {

            if ($user->id == 1) return ApiResponse::error(null, 'Not authorized to modify o deleted Admin user', Response::HTTP_FORBIDDEN);
            $this->userRepository->destroy($user);
            return ApiResponse::success(null, 'User deleted successfully', Response::HTTP_OK);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete user');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/get-by-email",
     *     tags={"User"},
     *     summary="Get a user by email",
     *     description="Retrieve a user by their email address",
     *     operationId="getUserByEmail",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=true,
     *         description="Email of the user to retrieve",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(ref="#/components/parameters/UserIncludeParam"),
     *     @OA\Response(response=200, ref="#/components/responses/UserSuccessId"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function getByEmail(Request $request) {
        try {

            $validData = $request->validate([ 'email' => 'required|email' ]);

            $userEmail = $this->userRepository->getByEmail( $validData['email'] );
            if (!$userEmail) return ApiResponse::error(null, 'User not found', Response::HTTP_NOT_FOUND);
            return ApiResponse::success( $userEmail, '', Response::HTTP_OK );
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve user by email');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/users/{user}/change-password",
     *     tags={"User"},
     *     summary="Change user password",
     *     description="Change the password of a user",
     *     operationId="changeUserPassword",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         required=true,
     *         description="ID of the user to change password",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateUserRequest"),
     *     @OA\Response(response=200, description="Password changed successfully"),
     *     @OA\Response(response=400, ref="#/components/responses/UserInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     * )
    */
    public function changePassword(UpdateUserRequest $request, User $user) {
        try {

            if (!$request->password) return ApiResponse::error(null, 'Password is required', Response::HTTP_BAD_REQUEST);
            $this->userRepository->changePassword($user, $request->password);
            return ApiResponse::success(null, 'Password changed successfully', Response::HTTP_OK);
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to change password');
        }
    }

}
