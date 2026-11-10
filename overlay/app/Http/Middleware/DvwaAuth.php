<?php

namespace App\Http\Middleware;

use Closure;

class DvwaAuth
{
    public function handle($request, Closure $next)
    {
        if (!session()->has('dvwa_user')) {
            return redirect('/login');
        }
        return $next($request);
    }
}
