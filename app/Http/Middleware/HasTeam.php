<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
     public function handle(Request $request, Closure $next)
    {

        if (\Auth::user() && \Auth::user()->currentTeam->count() === 0) {
            return Response(view('no-team'));
        }

        return $next($request);
    }
}
