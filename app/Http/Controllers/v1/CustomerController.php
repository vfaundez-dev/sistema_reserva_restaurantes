<?php

namespace App\Http\Controllers\v1;

use App\Models\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class CustomerController extends Controller {
    
    public function index() {
        try {
            
            $customers = Customer::all();
            return response()->json($customers);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Error getting customers'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function store(StoreCustomerRequest $request) {
        //
    }

    public function show(string $id) {
        try {

            $customer = Customer::findOrFail($id);
            return response()->json(['success' => true, 'data' => $customer], Response::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Customer not found'
            ], Response::HTTP_NOT_FOUND);
        }
    }

    public function update(UpdateCustomerRequest $request, Customer $customer) {
        //
    }

    public function destroy(Customer $customer) {
        //
    }
}
