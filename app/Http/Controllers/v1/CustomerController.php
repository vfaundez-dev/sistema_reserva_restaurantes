<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;

class CustomerController extends Controller {
    
    public function index() {
        $customers = Customer::all();
        return new CustomerCollection($customers);
    }

    public function store(StoreCustomerRequest $request) {
        $newCustomer = Customer::create( $request->validated() );
        return new CustomerResource( $newCustomer->fresh() );
    }

    public function show(Customer $customer) {
        return new CustomerResource($customer);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) {
        $customer->update( $request->validated() );
        return new CustomerResource( $customer->fresh() );
    }

    public function destroy(Customer $customer) {
        $customer->delete();
        return response()->json(['message' => 'Customer deleted'], 200);
    }
}
