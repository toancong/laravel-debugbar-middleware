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
        $this->publishConfig($this->getLocalConfigPath(), config_path('debugbar-middleware.php'));

        $debugbar_enable = request()->cookie('debugbar_enable', false);
        if ($debugbar_enable) {
            $matches = app('hash')->check(implode(':', [
                config('debugbar-middleware.allow.key'), // key to check if allow
                config('app.key'),
                date('Ymd'),
                request()->server('REMOTE_ADDR'),
            ]), $debugbar_enable);
            $matches && config(['debugbar.enabled' => true]);
        }
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig($this->getLocalConfigPath(), 'debugbar-middleware');
        $this->registerMiddleware(Debugbar::class);
    }

    private function getLocalConfigPath()
    {
        return __DIR__ . '/../config/debugbar-middleware.php';
    }

    protected function registerMiddleware($middleware)
    {
        $kernel = $this->app[Kernel::class];
        $kernel->pushMiddleware($middleware);
    }

    protected function publishConfig($localConfigPath, $appConfigPath, $tags = 'config')
    {
        $this->publishes([$localConfigPath => $appConfigPath], $tags);
    }

    protected function registerConfig($localConfigPath, $name)
    {
        $this->mergeConfigFrom($localConfigPath, $name);
    }
}
