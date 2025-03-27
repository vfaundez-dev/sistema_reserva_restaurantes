<?php

namespace App\Http\Controllers\v1;

use App\Models\Table;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\TableCollection;
use App\Http\Resources\TableResource;

class TableController extends Controller {
    
    public function index() {
        $tables = Table::all();
        return new TableCollection($tables);
    }

    public function store(StoreTableRequest $request) {
        $newTable = Table::create( $request->validated() );
        return new TableResource( $newTable->fresh() );
    }

    public function show(string $id) {
        $table = Table::find($id);
        if (!$table) return response()->json(['message' => 'Table not found'], 404);
        return new TableResource($table);
    }

    public function update(UpdateTableRequest $request, string $id) {
        $table = Table::find($id);
        if (!$table) return response()->json(['message' => 'Table not found'], 404);
        $table->update( $request->validated() );
        return new TableResource( $table->fresh() );
    }

    public function destroy(string $id) {
        $table = Table::find($id);
        if (!$table) return response()->json(['message' => 'Table not found'], 404);
        $table->delete();
        return response()->json(['message' => 'Table deleted'], 200);
    }
}
