<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AgentRole
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
        if(User::is_Agent()) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
