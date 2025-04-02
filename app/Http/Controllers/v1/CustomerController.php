<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Repositories\Interfaces\CustomerRepositoryInterfaces;

class CustomerController extends Controller {

    protected CustomerRepositoryInterfaces $customerRepository;

    public function __construct(CustomerRepositoryInterfaces $customerRepository)  {
        $this->customerRepository = $customerRepository;
    }
    
    public function index() {
        return $this->customerRepository->getAll();
    }

    public function store(StoreCustomerRequest $request) {
        return $this->customerRepository->store( $request->validated() );
    }

    public function show(Customer $customer) {
        return $this->customerRepository->getById($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) {
        return $this->customerRepository->update( $request->validated(), $customer );
    }

    public function destroy(Customer $customer) {
        $this->customerRepository->destroy($customer);
        return response()->json(['message' => 'Customer deleted'], 200);
    }
}
