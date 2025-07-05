<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Handler extends ExceptionHandler
{
    protected $levels = [
        //
    ];

    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            $exception = new NotFoundHttpException('Product not found', $exception);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('custom_errors.404', [], 404);
        }

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() === 403) {
            return response()->view('custom_errors.403', [], 403);
        }

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() === 419) {
            return response()->view('custom_errors.419', [], 419);
        }

        if (method_exists($exception, 'getStatusCode') && $exception->getStatusCode() === 500) {
            return response()->view('custom_errors.500', [], 500);
        }

        if ($exception instanceof TokenMismatchException) {
            return response()->view('custom_errors.419', [], 419);
        }

        return parent::render($request, $exception);
    }
}
