<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotInTeam
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::user()->allTeams()->count()) {
            $request->session()->flash('flash.banner', 'You must create or join a team before adding listings');
            $request->session()->flash('flash.bannerStyle', 'danger');
            return redirect(route('teams.join'));
        }

        return $next($request);
    }
}
