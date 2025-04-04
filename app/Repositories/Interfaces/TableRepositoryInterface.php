<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\TableCollection;
use App\Http\Resources\TableResource;
use App\Models\Table;

interface TableRepositoryInterface {
    public function getAll(): TableCollection;
    public function getById(Table $table): TableResource;
    public function store(array $data): TableResource;
    public function update(array $data, Table $table): TableResource;
    public function destroy(Table $table): bool;
    public function count(): int;
    public function exist(Table $table): bool;
    public function isAvailable(Table $table): bool;
    public function getAvailableTables(): TableCollection;
    public function releaseTable(Table $table): array;
    public function occupiedTable(Table $table): array;
    public function hasActiveReservation(Table $table, $excludeReservationId = null): bool;
}
