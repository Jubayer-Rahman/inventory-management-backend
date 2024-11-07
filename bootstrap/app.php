<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

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
            $exceptionDetails = getExceptionDetails($exception);

            $response = [
                'success' => false,
                'message' => $exceptionDetails['message'],
            ];

            // If the exception is ValidationException, add the 'errors' key
            if ($exception instanceof ValidationException) {
                $response['errors'] = $exception->validator->errors();
            }

            if (config('app.debug')) {
                $response['exception_type'] = get_class($exception);
                $response['file'] = $exception->getFile();
                $response['line'] = $exception->getLine();
            }

            return response()->json($response, $exceptionDetails['statusCode']);
        });

        function getExceptionDetails(Throwable $exception): array
        {
            return match (true) {
                $exception instanceof ModelNotFoundException || $exception instanceof NotFoundHttpException => [
                    'message' => config('app.debug') ? $exception->getMessage() : 'Data not found',
                    'statusCode' => Response::HTTP_NOT_FOUND,
                ],
                $exception instanceof ValidationException => [
                    'message' => $exception->validator->errors()->first(),
                    'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                ],
                $exception instanceof AuthenticationException, $exception instanceof UnauthorizedException => [
                    'message' => config('app.debug') ? $exception->getMessage() : 'Unauthenticated',
                    'statusCode' => Response::HTTP_UNAUTHORIZED,
                ],
                $exception instanceof UnprocessableEntityHttpException => [
                    'message' => config('app.debug') ? $exception->getMessage() : 'Unprocessable request',
                    'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
                ],
                default => [
                    'message' => config('app.debug') ? $exception->getMessage() : 'Something went wrong',
                    'statusCode' => Response::HTTP_INTERNAL_SERVER_ERROR,
                ],
            };
        }
    })->create();
