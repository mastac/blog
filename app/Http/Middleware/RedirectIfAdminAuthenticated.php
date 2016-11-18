<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfAdminAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        dd($request);

        if (\Auth::guard($guard)->check() && \Auth::user()->isAdmin()) {
            return redirect('/admin/home');
        }

        return $next($request);
    }
}
