<?php
namespace Bean\LaravelDebugbarMiddleware\Http\Middleware;

use Closure;

class Debugbar
{
/**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('debugbar_enable')) {
            return redirect($request->url())->withCookie(cookie('debugbar_enable', 1, 1440));
        }
        if ($request->has('debugbar_disable')) {
            return redirect($request->url())->withCookie(cookie('debugbar_enable', 0));
        }
        return $next($request);
    }
}
