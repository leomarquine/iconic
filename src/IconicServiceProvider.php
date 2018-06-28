<?php

namespace Marquine\Iconic;

use Illuminate\Support\ServiceProvider;

class IconicServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($config = $this->app['config']['iconic']) {
            Icon::config($config);
        }

        $this->publishes([
            __DIR__.'/../config/iconic.php' => config_path('iconic.php'),
        ], 'iconic');
    }
}
