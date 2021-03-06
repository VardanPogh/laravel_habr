<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(User::is_Admin() || User::is_SuperAdmin()) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}


