<?php

namespace App\Repositories;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Traits\Filterable;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserRepositoryInterface {
    use Filterable;

    protected $model;

    public function __construct() {
        $this->model = new User();
        $this->filterableFields = $this->model->getFillable();
        $this->searchableFields = array_diff( $this->filterableFields, ['password'] );
        $this->includes = ['reservations'];
    }

    public function getAll(): UserCollection {
        $query = $this->model->newQuery();
        $query = $this->applyFilters($query);
        return new UserCollection( $this->applyPagination($query) );
    }

    public function getById(User $user): UserResource {
        $query = $this->model->newQuery();
        $query = $this->aplyOnlyIncludeFilter($query);
        return UserResource::make( $query->findOrFail($user->id) );
    }

    public function create(array $data): UserResource {
        DB::beginTransaction();
        try {
            
            $newUser = User::create($data);
            $newUser->assignRole( $data['role'] ?? 'waiter' );
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
            
            if (isset($data['role'])) {
                $currentRole = $user->getRoleNames()->first();

                if ($data['role'] !== $currentRole) {
                    if ( $data['role'] === 'administrator' )
                        throw new \Exception('Denied assigning the administrator role');

                    $user->syncRoles([ $data['role'] ]);
                }
            }
            
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

            // Transfer reservations to the Admin user
            $user->reservations()->update(['user_id' => 1]);

            // Delete roles and permissions
            $user->syncRoles([]);
            $user->permissions()->detach();
            
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

        $query = $this->model->newQuery();
        $query = $this->aplyOnlyIncludeFilter($query);
        return UserResource::make( $query->findOrFail($user->id) );
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
