<?php

namespace App\Http\Middleware;

use App\Http\Responses\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProtectAdminUser {
    
    public function handle(Request $request, Closure $next): Response {

        if ($request->route('user') && $request->route('user')->id === 1) {
            if ( in_array($request->method(), ['PUT', 'PATCH', 'DELETE']) ) {
                return ApiResponse::error(null, 'Not authorized to modify o deleted Admin user', 403);
            }
        }

        return $next($request);
    }
}
