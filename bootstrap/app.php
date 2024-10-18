<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception) {
            $response = [
                'success' => false,
                'message' => getExceptionMessage($exception),
            ];

            // If the exception is ValidationException, add the 'errors' key
            if ($exception instanceof ValidationException) {
                $response['errors'] = $exception->validator->errors();
            }

            if (config('app.debug')) {
                $response['exception_type'] = get_class($exception);
                $response['file'] = $exception->getFile();
                $response['line'] = $exception->getLine();
                $response['trace'] = $exception->getTrace();
            }

            return response()->json($response, getStatusCode($exception));
        });

        function getExceptionMessage(Throwable $exception): string
        {
            return match (true) {
                $exception instanceof ModelNotFoundException => config('app.debug') ? $exception->getMessage() : 'Data not found',
                $exception instanceof ValidationException => $exception->validator->errors()->first(),
                $exception instanceof AuthenticationException, $exception instanceof UnauthorizedException => config('app.debug') ? $exception->getMessage() : 'Unauthenticated',
                default => config('app.debug') ? $exception->getMessage() : 'Something went wrong',
            };
        }

        function getStatusCode(Throwable $exception): int
        {
            return match (true) {
                $exception instanceof ModelNotFoundException => Response::HTTP_NOT_FOUND,
                $exception instanceof ValidationException => Response::HTTP_UNPROCESSABLE_ENTITY,
                $exception instanceof AuthenticationException, $exception instanceof UnauthorizedException => Response::HTTP_UNAUTHORIZED,
                default => Response::HTTP_INTERNAL_SERVER_ERROR,
            };
        }
    })->create();
