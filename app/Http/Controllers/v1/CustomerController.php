<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class CustomerController extends Controller {
    
    public function index(): CustomerCollection {
        $customers = Customer::all();
        return new CustomerCollection($customers);
    }

    public function store(StoreCustomerRequest $request) {
        $newCustomer = Customer::create( $request->validated() );
        return new CustomerResource( $newCustomer->fresh() );
    }

    public function show(string $id) {
        $customer = Customer::find($id);
        if (!$customer) return response()->json(['message' => 'Customer not found'], 404);
        return new CustomerResource($customer);
    }

    public function update(UpdateCustomerRequest $request, string $id) {
        $customer = Customer::find($id);
        if (!$customer) return response()->json(['message' => 'Customer not found'], 404);
        $customer->update( $request->validated() );
        return new CustomerResource( $customer->fresh() );
    }

    public function destroy(Customer $customer) {
        //
    }
}
