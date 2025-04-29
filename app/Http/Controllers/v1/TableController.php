<?php

namespace App\Http\Controllers\v1;

use App\Models\Table;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Repositories\Interfaces\TableRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class TableController extends Controller {

    protected TableRepositoryInterface $tableRepository;

    public function __construct(TableRepositoryInterface $tableRepository) {
        $this->tableRepository = $tableRepository;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tables",
     *     tags={"Tables"},
     *     summary="Get all tables",
     *     description="Retrieve a list of all tables.",
     *     operationId="getAllTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, ref="#/components/responses/TableSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function index() {
        try {
            return ApiResponse::success( $this->tableRepository->getAll(), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve tables');
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/tables",
     *     tags={"Tables"},
     *     summary="Create a new table",
     *     description="Create a new table.",
     *     operationId="createTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\RequestBody(ref="#/components/requestBodies/StoreTableRequest"),
     *     @OA\Response(response=201, ref="#/components/responses/TableSuccessId"),
     *     @OA\Response(response=400, ref="#/components/responses/TableInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function store(StoreTableRequest $request) {
        try {
            $newTable = $this->tableRepository->store($request->validated());
            return ApiResponse::success($newTable, 'Table created successfully');
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to create table');
        }
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tables/{table}",
     *     tags={"Tables"},
     *     summary="Get a table by ID",
     *     description="Retrieve a table by its ID.",
     *     operationId="getTableById",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="table",
     *         in="path",
     *         required=true,
     *         description="ID of the table to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, ref="#/components/responses/TableSuccessId"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function show(Table $table) {
        try {
            return ApiResponse::success( $this->tableRepository->getById($table), '', Response::HTTP_OK );
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve table');
        }
    }

    /**
     * @OA\Put(
     *     path="/api/v1/tables/{table}",
     *     tags={"Tables"},
     *     summary="Update a table",
     *     description="Update a table by its ID.",
     *     operationId="updateTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="table",
     *         in="path",
     *         required=true,
     *         description="ID of the table to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(ref="#/components/requestBodies/UpdateTableRequest"),
     *     @OA\Response(response=200, ref="#/components/responses/TableSuccessId"),
     *     @OA\Response(response=400, ref="#/components/responses/TableInvalidRequest"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function update(UpdateTableRequest $request, Table $table) {
        try {

            if ( $table->reservations()->whereIn('status', ['pending', 'confirmed'])->exists() )
                return ApiResponse::error(null, 'Cannot be updated. Table already in use.', Response::HTTP_UNPROCESSABLE_ENTITY);
            
            $updateTable = $this->tableRepository->update( $request->validated(), $table );
            return ApiResponse::success($updateTable, 'Table updated successfully', Response::HTTP_OK);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to update table');
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/tables/{table}",
     *     tags={"Tables"},
     *     summary="Delete a table",
     *     description="Delete a table by its ID.",
     *     operationId="deleteTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="table",
     *         in="path",
     *         required=true,
     *         description="ID of the table to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Table deleted successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function destroy(Table $table) {
        try {

            $this->tableRepository->destroy($table);
            return ApiResponse::success(null, 'Table deleted successfully', Response::HTTP_OK);
            
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to delete table');
        }
    }

    public function isAvailable(Table $table) {
        return $this->tableRepository->isAvailable($table);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tables/availables",
     *     tags={"Tables"},
     *     summary="Get available tables",
     *     description="Retrieve a list of available tables.",
     *     operationId="getAvailableTables",
     *     security={{"BearerAuth": {}}},
     *     @OA\Response(response=200, ref="#/components/responses/TableSuccess"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function getAvailableTables() {
        try {
            $tables = $this->tableRepository->getAvailableTables();
            return ApiResponse::success($tables, '', Response::HTTP_OK);
        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to retrieve available tables');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/tables/{table}/release",
     *     tags={"Tables"},
     *     summary="Release a table",
     *     description="Release a table by its ID.",
     *     operationId="releaseTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="table",
     *         in="path",
     *         required=true,
     *         description="ID of the table to release",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Table released successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function release(Table $table) {
        try {

            $result = $this->tableRepository->releaseTable($table);
            return ApiResponse::success(null, $result['message'], Response::HTTP_OK);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to release table');
        }
    }

    /**
     * @OA\Patch(
     *     path="/api/v1/tables/{table}/occupied",
     *     tags={"Tables"},
     *     summary="Occupied a table",
     *     description="Occupied a table by its ID.",
     *     operationId="occupiedTable",
     *     security={{"BearerAuth": {}}},
     *     @OA\Parameter(
     *         name="table",
     *         in="path",
     *         required=true,
     *         description="ID of the table to occupied",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Table occupied successfully"),
     *     @OA\Response(response=401, ref="#/components/responses/UnauthenticatedError"),
     *     @OA\Response(response=403, ref="#/components/responses/UnauthorizedError"),
     *     @OA\Response(response=404, ref="#/components/responses/NotFoundError"),
     *     @OA\Response(response=500, ref="#/components/responses/ServerError")
     * )
    */
    public function occupied(Table $table) {
        try {

            $result = $this->tableRepository->occupiedTable($table);
            return ApiResponse::success(null, $result['message'], Response::HTTP_OK);

        } catch (Throwable $e) {
            return ApiResponse::exception($e, 'Failed to release table');
        }
    }

}
