<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ... $roles)
    {
        // dd(Auth::user()->role_id);
        foreach ($roles as $role) {
            if (Auth::user()->role_id == $role)
                return $next($request);
        }

        abort(403, "Cannot access to restricted page");
    }
}
