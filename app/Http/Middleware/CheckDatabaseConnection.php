<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckDatabaseConnection
{
    public function handle(Request $request, Closure $next)
    {
        try {
            DB::select('SELECT 1');
        } catch (\Exception $e) {
            return response()->view('pages.error.db', [], 503);
        }

        return $next($request);
    }
}
