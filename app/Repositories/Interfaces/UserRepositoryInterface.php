<?php

namespace App\Repositories\Interfaces;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;

interface UserRepositoryInterface {
    public function getAll(): UserCollection;
    public function getById(User $user): UserResource;
    public function create(array $data): UserResource;
    public function update(array $data, User $user): UserResource;
    public function destroy(User $user): bool;
    public function count(): int;
    public function exist(User $user): bool;
    public function getByEmail(string $email): ?UserResource;
    public function changePassword(User $user, string $password): bool;
}
