<?php

namespace App\Repositories;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterfaces;

class CustomerRepository implements CustomerRepositoryInterfaces {

  public function getAll(): CustomerCollection {
    return new CustomerCollection( Customer::all() );
  }

  public function getById(Customer $customer): CustomerResource {
    return CustomerResource::make($customer);
  }

  public function store(array $data): CustomerResource {
    $newCustomer = Customer::create($data);
    return CustomerResource::make( $newCustomer->fresh() );
  }

  public function update(array $data, Customer $customer): CustomerResource {
    $customer->update($data);
    return CustomerResource::make( $customer->fresh() );
  }

  public function destroy(Customer $customer): bool {
    return $customer->delete();
  }

  public function count(): int {
    return Customer::count();
  }

  public function exist(Customer $customer): bool {
    return Customer::where('id', $customer)->exists();
  }

}