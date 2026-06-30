<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceLogout
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {

            $lastActivity = session('last_activity');

            if ($lastActivity && (time() - $lastActivity > 60)) { // 1 minute
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect('/auth/login')
                       ->withErrors('Session expired. Please login again.');
            }

            session(['last_activity' => time()]);
        }

        return $next($request);
    }
}