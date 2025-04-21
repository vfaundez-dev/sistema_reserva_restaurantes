<?php

namespace App\Repositories;

use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use App\Repositories\Interfaces\CustomerRepositoryInterfaces;
use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CustomerRepository implements CustomerRepositoryInterfaces {
  Use Filterable;

  protected $model;

  public function __construct() {
    $this->model = new Customer();
    $this->filterableFields = $this->model->getFillable();
    $this->searchableFields = array_diff( $this->filterableFields, ['registration_date'] );
    $this->includes = ['reservations'];
  }

  public function getAll(): CustomerCollection {

    $query = $this->model->newQuery();
    $query = $this->applyFilters($query);
    return new CustomerCollection( $this->applyPagination($query) );

  }

  public function getById(Customer $customer): CustomerResource {

    $query = $this->model->newQuery();
    $query = $this->aplyOnlyIncludeFilter($query);
    return CustomerResource::make( $query->findOrFail($customer->id) );

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