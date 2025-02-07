<?php

namespace MNobre\TeamProfiler\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectTeamRoutes
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(str_contains(request()->path(), 'team') && !str_contains(request()->path(), config('team-profiler.denomination', 'team')) && !str_contains(request()->path(), 'team-')) {
            $path = str_replace('team', config('team-profiler.denomination', 'team'), request()->path());

            return redirect($path);
        }

        return $next($request);
    }
}
