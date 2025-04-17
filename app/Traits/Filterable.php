<?php

namespace App\Traits;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait Filterable {

    protected array $filterableFields = [];
    protected array $searchableFields = [];
    protected array $sortableFields = ['id'];
    protected array $includes = [];
    
    /**
    * Apply filters to query
    *
    * @param Builder $query
    * @param array $allowedFilters
    * @return Builder
    */
    public function applyFilters(Builder $query): Builder {
        $request = app(Request::class);
        $queryParams = $request->query();

        // Exact Filters
        foreach ($this->filterableFields as $field) {
            if ( isset($queryParams[$field]) ) {
                $query->where($field, $queryParams[$field]);
            }
        }

        // Textual Filters
        if ( isset($queryParams['search']) && !empty($this->searchableFields) ) {
            $searchTerm = $queryParams['search'];
            $query->where(function($q) use ($searchTerm) {
                foreach ($this->searchableFields as $field) {
                    $q->orWhere($field, 'like', "%{$searchTerm}%");
                }
            });
        }

        // Ordering
        $this->applyOrdering($query, $request);

        // Search by Date Range
        if ($request->has('date_from') || $request->has('date_to')) {
            $this->applyDateFilters($query, $request);
        }

        // Include relationships
        if ( $request->has('include') ) {
            $this->loadRelationships($query, $request);
        }

        return $query;
    }

    /**
    * Apply Pagination
    *
    * @param Builder $query
    * @return mixed
    */
    public function applyPagination(Builder $query): LengthAwarePaginator {
        $request = app(Request::class);
        
        $perPage = $request->input('per_page', 15);
        $page = $request->input('page', 1);
        
        return $query->paginate($perPage, ['*'], 'page', $page);
    }

    protected function applyDateFilters(Builder $query, Request $request): void {
        $dateField = $request->input('date_field', 'created_at');

        try {

            if ($request->has('date_from')) {
                $dateFrom = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('date_from'));
                $query->whereDate($dateField, '>=', $dateFrom);
            }

            if ($request->has('date_to')) {
                $dateTo = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('date_to'));
                $query->whereDate($dateField, '<=', $dateTo);
            }

        } catch (\Exception $e) {
            throw new \Exception('Invalid date format. Please use YYYY-MM-DD format', 422);
        }
    }

    protected function applyOrdering(Builder $query, Request $request): void {

        if ($request->has('sort_by') || $request->has('sort_dir')) {
            $sortBy = $request->input('sort_by', 'id');
            
            if ( in_array($sortBy, $this->sortableFields) ) {
                $direction = $request->input('sort_dir', 'asc');
                $query->orderBy($sortBy, $direction);
                return;
            }
        }

        $query->orderBy('id', 'desc');
    }

    protected function loadRelationships(Builder $query, Request $request): void {
        $requestedRelations = explode(',', $request->input('include'));
        $validRelations = array_intersect($requestedRelations, $this->includes);
        
        if (!empty($validRelations)) {
            $query->with($validRelations);
        }
    }

}
