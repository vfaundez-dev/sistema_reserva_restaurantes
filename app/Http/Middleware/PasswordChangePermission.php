<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PasswordChangePermission {
    
    public function handle(Request $request, Closure $next): Response {

        $user = auth()->user();
        $targetUser = $request->route('user');

        if ($user->hasRole('administrator')) {
            return $next($request);
        }

        if ($user->id == $targetUser) {
            return $next($request);
        }

        return ApiResponse::error(null, 'Unauthorized action', 403);
    }

}
