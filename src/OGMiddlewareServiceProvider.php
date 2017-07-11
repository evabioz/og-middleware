<?php

namespace Evabioz\OGMiddleware;

use Illuminate\Foundation\Http\Kernel;
use Illuminate\Support\ServiceProvider;

class OGMiddlewareServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    protected $package = 'evabioz/og-middleware';

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../views', 'og-middleware');

        $this->publishes([
            __DIR__ . '/../config/og-middleware.php' => config_path('og-middleware.php')
        ], 'config');

        /** @var Kernel $kernel */
        $kernel = $this->app['Illuminate\Contracts\Http\Kernel'];
        $kernel->pushMiddleware(OGMiddleware::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/og-middleware.php',
            'og-middleware'
        );
    }

}