<?php

namespace App\Repositories;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterfaces;
use Illuminate\Support\Facades\DB;

class CustomerRepository implements CustomerRepositoryInterfaces {

  public function getAll(): CustomerCollection {
    return new CustomerCollection( Customer::orderBy('id', 'desc')->get() );
  }

  public function getById(Customer $customer): CustomerResource {
    return CustomerResource::make($customer);
  }

  public function store(array $data): CustomerResource {
    DB::beginTransaction();
    try {
      
      $newCustomer = Customer::create($data);
      DB::commit();
      return CustomerResource::make( $newCustomer->fresh() );

    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function update(array $data, Customer $customer): CustomerResource {
    DB::beginTransaction();
    try {

      $customer->update($data);
      DB::commit();
      return CustomerResource::make( $customer->fresh() );

    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function destroy(Customer $customer): bool {
    DB::beginTransaction();
    try {

      $deleted = $customer->delete();
      DB::commit();
      return $deleted;

    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function count(): int {
    return Customer::count();
  }

  public function exist(Customer $customer): bool {
    return Customer::where('id', $customer->id)->exists();
  }

}