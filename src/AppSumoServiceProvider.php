<?php

namespace YourNamespace\AppSumo;

use Illuminate\Support\ServiceProvider;

class AppSumoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot()
    {
        // Publish the configuration file
        $this->publishes([
            __DIR__.'/../config/appsumo.php' => config_path('appsumo.php'),
        ], 'config');

        // Load routes from the package
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        // Merge package configuration with application configuration
        $this->mergeConfigFrom(__DIR__.'/../config/appsumo.php', 'appsumo');
    }
}
