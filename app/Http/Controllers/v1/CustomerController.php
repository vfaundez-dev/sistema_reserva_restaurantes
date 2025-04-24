<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repositories\Interfaces\CustomerRepositoryInterfaces;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CustomerController extends Controller {

    protected CustomerRepositoryInterfaces $customerRepository;

    public function __construct(CustomerRepositoryInterfaces $customerRepository)  {
        $this->customerRepository = $customerRepository;
    }
    
    /**
     * @OA\Get(
     *     path="/api/v1/customers",
     *     summary="Get all customers",
     *     operationId="getAllCustomers",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="List of customers",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve customers",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function index() {
        try {
            return ApiResponse::success( $this->customerRepository->getAll() );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve customers');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/customers",
     *     summary="Create a new customer",
     *     operationId="createCustomer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(
     *         response=201,
     *         description="Customer created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to create customer",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function store(StoreCustomerRequest $request) {
        try {
            $newCustomer = $this->customerRepository->store( $request->validated() );
            return ApiResponse::success($newCustomer, 'Customer created successfully', Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to create customer');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/customers/{id}",
     *     summary="Get customer by ID",
     *     operationId="getCustomerById",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Customer ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer retrieved successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Customer not found",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to retrieve customer",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function show(Customer $customer) {
        try {
            return ApiResponse::success( $this->customerRepository->getById($customer) );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve customer');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/customers/{id}",
     *     summary="Update an existing customer",
     *     operationId="updateCustomer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Customer ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update customer",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function update(UpdateCustomerRequest $request, Customer $customer) {
        try {
            $updateCustomer = $this->customerRepository->update( $request->validated(), $customer );
            return ApiResponse::success($updateCustomer, 'Customer updated successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update customer');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/customers/{id}",
     *     summary="Delete a customer",
     *     operationId="deleteCustomer",
     *     tags={"Customers"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Customer ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Customer deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SuccessResponse")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to delete customer",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
    */
    public function destroy(Customer $customer) {
        try {
            $this->customerRepository->destroy($customer);
            return ApiResponse::success(null, 'Customer deleted successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete customer');
        }
    }
}
