<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        if (!app()->isLocal()) {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    	if ($this->app->environment('local')) {
    	    $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
    	    $this->app->alias('Debugbar', \Barryvdh\Debugbar\Facade::class);
        }
    }
}
