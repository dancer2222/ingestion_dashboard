<?php

namespace App\Providers\Apis;

use Illuminate\Support\ServiceProvider;

class GoogleClientServiceProvider extends ServiceProvider
{
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
        $filepath = env('GOOGLE_API_CREDS_FILE') ?: '/conf/google_creds.json';

        if (file_exists($filepath)) {
            $this->app->singleton(\Google_Client::class, function () use ($filepath) {
                $client = new \Google_Client();
                $client->setAuthConfig($filepath);
                $client->setScopes([\Google_Service_Gmail::MAIL_GOOGLE_COM]);

                return $client;
            });
        }
    }
}
