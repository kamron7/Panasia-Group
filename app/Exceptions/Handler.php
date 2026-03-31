<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Http\Request;

class Handler extends ExceptionHandler
{
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return parent::render($request, $exception);
        }

        if ($exception instanceof ThrottleRequestsException) {
            return response()->view('errors.429', ['banned' => false], 429);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', [], 404);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() === 500) {
            return response()->view('errors.500', [], 500);
        }

        if ($exception instanceof HttpException && $exception->getStatusCode() === 503) {
            return response()->view('errors.503', [], 503);
        }

        return parent::render($request, $exception);
    }
}
