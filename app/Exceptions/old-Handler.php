<?php

namespace App\Exceptions;

use Throwable;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Database\ConnectionException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {

        // SESSION EXPIRED (419)
        if ($exception instanceof TokenMismatchException) {

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'message' => 'Session expired'
                ], 419);
            }

            return redirect('/');
        }

        // DB ERROR
        if ($exception instanceof QueryException ||
            $exception instanceof ConnectionException) {

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Service temporarily unavailable.'
                ], 503);
            }

            return response()->view('pages.error.db', [], 503);
        }

        return parent::render($request, $exception);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return redirect('/');
    }
}