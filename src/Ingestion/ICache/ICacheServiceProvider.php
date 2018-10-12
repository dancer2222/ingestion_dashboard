<?php

namespace Ingestion\ICache;

use Illuminate\Support\ServiceProvider;

class ICacheServiceProvider extends ServiceProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->bind('icache', ICache::class);
    }

    public function provides()
    {
        return [ICache::class];
    }
}
