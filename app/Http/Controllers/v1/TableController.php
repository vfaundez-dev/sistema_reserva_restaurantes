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

    public function getAvailableTables() {
        $availableTables = Table::where('is_available', true)->get();
        return new TableCollection($availableTables);
    }
    
    public function isAvailable(string $id) {
        return Table::find($id)->is_available;
    }

    public function release(string $id) {
        $table = Table::find($id);
        if (!$table) return response()->json(['message' => 'Table not found'], 404);
        // Validations
        if ($table->is_available) return response()->json(['message' => 'Table already released'], 200);
        if ( $table->reservations()->whereIn('status', ['pending', 'confirmed'])->exists() )
            return response()->json(['message' => 'Cannot mark as released. There is an active reservation.'], 200);

        $table->update(['is_available' => true]);
        return response()->json(['message' => 'Released table'], 200);
    }

    public function occupied(string $id) {
        $table = Table::find($id);
        if (!$table) return response()->json(['message' => 'Table not found'], 404);
        // Validations
        if (!$table->is_available) return response()->json(['message' => 'Table already available'], 200);

        $table->update(['is_available' => false]);
        return response()->json(['message' => 'Table occupied'], 200);
    }
    
}
