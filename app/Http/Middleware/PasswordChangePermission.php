<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordChangePermission {
    
    public function handle(Request $request, Closure $next): Response {

        if (!$request->user()) {
            return ApiResponse::error(null, 'Unauthenticated', 401);
        }

        $user = $request->user();
        $targetUserId = $request->route('user');

        if ( $user->hasRole('administrator') || $user->id == $targetUserId ) {
            return $next($request);
        }

        return ApiResponse::error(null, 'Unauthorized action', 403);
    }

}
