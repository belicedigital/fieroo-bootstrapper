<?php

namespace Fieroo\Bootstrapper\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapperProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        $this->loadViewsFrom(__DIR__.'/../views', 'bootstrapper');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'yourpackage');
        
    }
}