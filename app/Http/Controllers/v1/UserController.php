<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller {
    
    public function index() {
        $users = User::all();
        return new UserCollection($users);
    }

    public function store(StoreUserRequest $request) {
        $newUser = User::create( $request->validated() );
        return new UserResource( $newUser->fresh() );
    }

    public function show(string $id) {
        $user = User::find($id);
        if(!$user) return response()->json(['message' => 'User not found'], 404);
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, string $id) {
        //
    }

    public function destroy(string $id) {
        //
    }
}
