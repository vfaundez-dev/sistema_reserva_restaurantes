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
    
    public function index() {
        try {
            return ApiResponse::success( $this->customerRepository->getAll() );
        } catch (Throwable $e) {
            return ApiResponse::error($e, 'Failed to retrieve customers');
        }
    }

    public function store(StoreCustomerRequest $request) {
        try {
            $newCustomer = $this->customerRepository->store( $request->validated() );
            return ApiResponse::success($newCustomer, 'Customer created successfully', Response::HTTP_CREATED);
        } catch (Throwable $e) {
            return ApiResponse::error($e, 'Failed to create customer');
        }
    }

    public function show(Customer $customer) {
        try {
            return ApiResponse::success( $this->customerRepository->getById($customer) );
        } catch (Throwable $e) {
            return ApiResponse::error($e, 'Failed to retrieve customer');
        }
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) {
        try {
            $updateCustomer = $this->customerRepository->update( $request->validated(), $customer );
            return ApiResponse::success($updateCustomer, 'Customer updated successfully');
        } catch (Throwable $e) {
            return ApiResponse::error($e, 'Failed to update customer');
        }
    }

    public function destroy(Customer $customer) {
        try {
            $this->customerRepository->destroy($customer);
            return ApiResponse::success(null, 'Customer deleted successfully');
        } catch (Throwable $e) {
            return ApiResponse::error($e, 'Failed to delete customer');
        }
    }
}
