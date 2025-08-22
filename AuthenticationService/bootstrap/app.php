<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\QueryException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        });

        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
            return response()->json([
                'message' => 'Resource not found',
            ], 404);
        });

        $exceptions->render(function (QueryException $e, Request $request) {
            return response()->json([
                'message' => 'Database error',
                'error' => $e->getMessage(),
            ], 500);
        });

        $exceptions->render(function (ExpiredException $e, Request $request) {
            return response()->json([
                'message' => 'Token has expired',
            ], 401);
        });

        $exceptions->render(function (SignatureInvalidException $e, Request $request) {
            return response()->json([
                'message' => 'Invalid token signature',
            ], 401);
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            return response()->json([
                'message' => $e->getMessage() ?: 'Server error',
            ], 500);
        });
    })->create();
