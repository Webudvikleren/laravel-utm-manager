<?php

namespace Webudvikleren\UtmManager;

use Illuminate\Support\ServiceProvider;

class UtmTrackerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/utm.php' => config_path('utm.php'),
        ], 'config');

        $this->app['router']->aliasMiddleware('utm.capture', Http\Middleware\CaptureUtmParameters::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/utm.php', 'utm');

        $this->app->singleton('utm', function () {
            return new UtmManager();
        });
    }
}
