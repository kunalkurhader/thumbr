<?php

namespace Kurhades\Thumbr;

use Illuminate\Support\ServiceProvider;

class ThumbrServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('thumbr.php'),
            ], 'config');
        }
    }
}
