<?php

namespace Ingestion\ICache;

use Illuminate\Support\ServiceProvider;

class ICacheServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('icache', function () {
            return new ICache();
        });
    }
}
