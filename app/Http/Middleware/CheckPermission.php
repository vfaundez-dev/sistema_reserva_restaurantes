<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission {
    
    public function handle(Request $request, Closure $next, $permission): Response {

        if (!$request->user()) {
            return ApiResponse::error(null, 'Unauthenticated', 401);
        }

        if ( !$request->user() && $request->user()->can($permission) ) {
            return ApiResponse::error(null, 'Unauthorized action', 403);
        }

        return $next($request);
    }
}
