<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Database\QueryException;
use Illuminate\Database\Connectors\ConnectionException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Session\TokenMismatchException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param \Exception $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Exception $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        // Session expired / CSRF token mismatch
        if ($exception instanceof TokenMismatchException) {

            // Save current URL for redirect after login
            session(['url.intended' => url()->current()]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'redirect' => url('/auth/login'),
                    'message'  => 'Session expired'
                ], 419);
            }

            return redirect('/auth/login?expired=1');
        }

        // Database errors
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

    /**
     * Handle unauthenticated users.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return mixed
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Save current URL before redirecting to login
        session(['url.intended' => url()->current()]);

        if ($request->ajax() || $request->expectsJson()) {
            return response()->json([
                'redirect' => url('/auth/login'),
                'message'  => 'Unauthenticated'
            ], 401);
        }

        return redirect('/auth/login');
    }
}