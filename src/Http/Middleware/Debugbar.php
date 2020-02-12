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
            $code = app('hash')->make(implode(':', [
                $request->debugbar_enable, // key to check if allow from config
                config('app.key'), // This is secret, so that nobody else can fake this cookie
                date('Ymd'), // Force the cookie to expire tomorrow
                $request->server('REMOTE_ADDR'), // Cookie only valid for current IP
            ]));
            return redirect($request->url())->withCookie(cookie('debugbar_enable', $code, 1440));
        }
        if ($request->has('debugbar_disable')) {
            return redirect($request->url())->withCookie(cookie('debugbar_enable', 0));
        }
        return $next($request);
    }
}
