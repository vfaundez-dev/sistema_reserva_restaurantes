<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'protected.admin' => \App\Http\Middleware\ProtectAdminUser::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'password.change' => \App\Http\Middleware\PasswordChangePermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            if ($request->wantsJson() || $request->is('api/*')) {
                $previous = $e->getPrevious();
                
                if ($previous instanceof ModelNotFoundException) {
                    $modelName = class_basename($previous->getModel());
                    return response()->json([
                        'success' => false,
                        'message' => "$modelName not found",
                        'data' => null
                    ], 404);
                }
                
                return response()->json([
                    'success' => false,
                    'message' => 'Endpoint not found',
                    'data' => null
                ], 404);
            }
        });

    })->create();
