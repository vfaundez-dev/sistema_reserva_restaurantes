<?php

namespace App\Repositories;

use App\Http\Resources\TableCollection;
use App\Http\Resources\TableResource;
use App\Models\Table;
use App\Repositories\Interfaces\TableRepositoryInterface;
use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;

class TableRepository implements TableRepositoryInterface {
    use Filterable;

    protected $model;

    public function __construct() {
        $this->model = new Table();
        $this->filterableFields = $this->model->getFillable();
        $this->searchableFields = $this->model->getFillable();
        $this->includes = ['reservations'];
    }
    
    public function getAll(): TableCollection {
        $query = $this->model->newQuery();
        $query = $this->applyFilters($query);
        return new TableCollection( $this->applyPagination($query) );
    }

    public function getById(Table $table): TableResource {
        $query = $this->model->newQuery();
        $query = $this->aplyOnlyIncludeFilter($query);
        return TableResource::make( $query->findOrFail($table->id) );
    }

    public function store(array $data): TableResource {
        DB::beginTransaction();
        try {
            
            $newTable = Table::create($data);
            DB::commit();
            return TableResource::make( $newTable->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, Table $table): TableResource {
        DB::beginTransaction();
        try {
            
            $table->update($data);
            DB::commit();
            return TableResource::make( $table->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(Table $table): bool {
        DB::beginTransaction();
        try {
            
            if ( !$table->is_available && $table->reservations()->whereIn('status', ['pending', 'confirmed'])->exists() )
                throw new \Exception('Cannot be deleted. Table already in use.');

            $deleted = $table->delete();
            DB::commit();
            return $deleted;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function count(): int {
        return Table::count();
    }

    public function exist(Table $table): bool {
        return Table::where('id', $table->id)->exists();
    }

    public function isAvailable(Table $table): bool {
        return $table->is_available;
    }

    public function getAvailableTables(): TableCollection {
        $query = $this->model->newQuery();
        $query = $this->applyFilters($query->where('is_available', true));
        return new TableCollection( $this->applyPagination($query) );
    }

    public function hasActiveReservation(Table $table, $excludeReservationId = null): bool {
        $query = $table->reservations()->whereIn('status', ['pending', 'confirmed']);

        if ($excludeReservationId) {
            $query->where('id', '!=', $excludeReservationId);
        }

        return $query->exists();
    }

    public function releaseTable(Table $table): array {
        DB::beginTransaction();
        try {

            if ($table->is_available) return ['message' => 'Table already released'];
            if ($table->reservations()->whereIn('status', ['pending', 'confirmed'])->exists()) {
                return ['message' => 'Cannot mark as released. There is an active reservation.'];
            }

            $table->update(['is_available' => true]);
            DB::commit();
            return ['message' => 'Released table'];
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function occupiedTable(Table $table): array {
        DB::beginTransaction();
        try {
            
            if (!$table->is_available) return ['message' => 'Table already occupied'];
            $table->update(['is_available' => false]);
            DB::commit();
            return ['message' => 'Table occupied'];
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
