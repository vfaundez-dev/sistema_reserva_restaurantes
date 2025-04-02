<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;

interface CustomerRepositoryInterfaces {
  public function getAll(): CustomerCollection;
  public function getById(Customer $customer): CustomerResource;
  public function store(array $data): CustomerResource;
  public function update(array $data, Customer $customer): CustomerResource;
  public function destroy(Customer $customer): bool;
  public function count(): int;
  public function exist(Customer $customer): bool;
}