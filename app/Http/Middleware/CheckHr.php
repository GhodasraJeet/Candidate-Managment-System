<?php

namespace App\Http\Middleware;

use Closure;

class CheckHr
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
        if(isset(auth()->user()->role) && auth()->user()->role=="hr" )
        {
            return $next($request);
        }
        return redirect()->route('hr.login');
    }
}
