<?php

namespace App\Http\Controllers\v1;

use App\Models\Table;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repositories\Interfaces\TableRepositoryInterface;
use Throwable;

class TableController extends Controller {

    protected TableRepositoryInterface $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository) {
        $this->tableRepository = $tableRepository;
    }

    public function index() {
        try {
            return ApiResponse::success( $this->tableRepository->getAll() );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve tables');
        }
    }

    public function store(StoreTableRequest $request) {
        try {
            $newTable = $this->tableRepository->store($request->validated());
            return ApiResponse::success($newTable, 'Table created successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to create table');
        }
    }

    public function show(Table $table) {
        try {
            return ApiResponse::success( $this->tableRepository->getById($table) );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve table');
        }
    }

    public function update(UpdateTableRequest $request, Table $table) {
        try {
            $updateTable = $this->tableRepository->update( $request->validated(), $table );
            return ApiResponse::success($updateTable, 'Table updated successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update table');
        }
    }

    public function destroy(Table $table) {
        try {
            $this->tableRepository->destroy($table);
            return ApiResponse::success(null, 'Table deleted successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete table');
        }
    }

    public function isAvailable(Table $table) {
        return $this->tableRepository->isAvailable($table);
    }

    public function getAvailableTables() {
        try {
            $tables = $this->tableRepository->getAvailableTables();
            return ApiResponse::success($tables);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve available tables');
        }
    }

    public function release(Table $table) {
        try {

            $result = $this->tableRepository->releaseTable($table);
            return ApiResponse::success(null, $result['message']);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to release table');
        }
    }

    public function occupied(Table $table) {
        try {

            $result = $this->tableRepository->occupiedTable($table);
            return ApiResponse::success(null, $result['message']);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to release table');
        }
    }

}
