<?php

namespace App\Providers;

use GuzzleHttp\Client;
use Illuminate\Support\ServiceProvider;
use App\Helpers\Ingestion\Tags\LibraryThingHelper;

class LibraryThingHelperProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(LibraryThingHelper::class, function () {
            $guzzle = new Client();

            return new LibraryThingHelper($guzzle);
        });
    }

    /**
     * @inheritdoc
     * @return array
     */
    public function provides() {
        return [LibraryThingHelper::class];
    }
}
