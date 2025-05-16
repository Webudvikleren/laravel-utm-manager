<?php

namespace Webudvikleren\UtmManager;

use Illuminate\Support\ServiceProvider;

class UtmManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/utm.php' => config_path('utm.php'),
        ], 'config');

        $this->app['router']->aliasMiddleware('utm.capture', Http\Middleware\CaptureUtmParameters::class);

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Webudvikleren\UtmManager\Commands\PublishUtmModelCommand::class,
                \Webudvikleren\UtmManager\Commands\UtmMakeMigrationCommand::class,
            ]);
        }
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/utm.php', 'utm');

        $this->app->singleton('utm', function () {
            return new UtmManager();
        });
    }
}
