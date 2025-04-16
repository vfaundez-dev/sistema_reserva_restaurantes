<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission {
    
    public function handle(Request $request, Closure $next, $permission): Response {

        if (!$request->user()) {
            return ApiResponse::error(null, 'Unauthenticated!', 401);
        }

        $permissions = is_array($permission) 
            ? $permission 
            : explode('|', $permission);

        foreach ($permissions as $perm) {
            if ($request->user()->can($perm)) {
                return $next($request);
            }
        }

        return ApiResponse::error(null, 'Unauthorized!', 403);
    }
}
