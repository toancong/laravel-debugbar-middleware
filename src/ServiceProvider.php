<?php

namespace Bean\LaravelDebugbarMiddleware;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider as Provider;
use Bean\LaravelDebugbarMiddleware\Http\Middleware\Debugbar;

class ServiceProvider extends Provider
{
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        $debugbar_enable = request()->cookie('debugbar_enable', false);
        if ($debugbar_enable) {
            config(['debugbar.enabled' => true]);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerMiddleware(Debugbar::class);
    }

    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }
}
