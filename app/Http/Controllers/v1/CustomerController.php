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
     *     tags={"Customers"},
     *     summary="Get all customers",
     *     description="Retrieve a list of all customers.",
     *     operationId="getAllCustomers",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, ref="#/components/responses/CustomerSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function index() {
        try {
            return ApiResponse::success( $this->customerRepository->getAll(), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve customers');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/customers",
     *     tags={"Customers"},
     *     summary="Create a new customer",
     *     description="Store a new customer in the system.",
     *     operationId="storeCustomer",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreCustomerRequest"),
     *     @OA\Response(response=201, ref="#/components/responses/CustomerSuccess"),
     *     @OA\Response(response=400, ref="#/components/responses/InvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
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
     *     path="/api/v1/customers/{customer}",
     *     tags={"Customers"},
     *     summary="Get a customer by ID",
     *     description="Retrieve a specific customer by their ID.",
     *     operationId="getCustomerById",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/CustomerSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function show(Customer $customer) {
        try {
            return ApiResponse::success( $this->customerRepository->getById($customer), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve customer');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/customers/{customer}",
     *     tags={"Customers"},
     *     summary="Update a customer",
     *     description="Update an existing customer in the system.",
     *     operationId="updateCustomer",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateCustomerRequest"),
     *     @OA\Response(response=200, ref="#/components/responses/CustomerSuccess"),
     *     @OA\Response(response=400, ref="#/components/responses/InvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function update(UpdateCustomerRequest $request, Customer $customer) {
        try {
            $updateCustomer = $this->customerRepository->update( $request->validated(), $customer );
            return ApiResponse::success($updateCustomer, 'Customer updated successfully', Response::HTTP_OK);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update customer');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/customers/{customer}",
     *     tags={"Customers"},
     *     summary="Delete a customer",
     *     description="Remove a specific customer from the system.",
     *     operationId="deleteCustomer",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="customer",
     *         in="path",
     *         required=true,
     *         description="ID of the customer to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=204, description="Customer deleted successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function destroy(Customer $customer) {
        try {
            $this->customerRepository->destroy($customer);
            return ApiResponse::success(null, 'Customer deleted successfully', Response::HTTP_NO_CONTENT);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete customer');
        }
    }
}
