<?php

namespace App\Repositories;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface {

    public function getAll(): UserCollection {
        return new UserCollection( User::all() );
    }

    public function getById(User $user): UserResource {
        return UserResource::make($user);
    }

    public function create(array $data): UserResource {
        DB::beginTransaction();
        try {
            
            $newUser = User::create($data);
            DB::commit();
            return UserResource::make( $newUser->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function update(array $data, User $user): UserResource {
        DB::beginTransaction();
        try {

            $user->update($data);
            DB::commit();
            return UserResource::make( $user->fresh() );
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function destroy(User $user): bool {
        DB::beginTransaction();
        try {

            $deleted = $user->delete();
            DB::commit();
            return $deleted;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function count(): int {
        return User::count();
    }

    public function exist(User $user): bool {
        return User::where('id', $user->id)->exists();
    }

    public function getByEmail(string $email): ?UserResource {
        $user = User::where('email', $email)->first();
        if (!$user) return null;
        return UserResource::make( $user );
    }

    public function changePassword(User $user, string $password):bool {
        DB::beginTransaction();
        try {
            
            $user->update(['password' => bcrypt($password)]);
            DB::commit();
            return true;
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
