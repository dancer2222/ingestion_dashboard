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
        if (file_exists(env('GOOGLE_API_CREDS_FILE'))) {
            $this->app->singleton(\Google_Client::class, function () {
                $client = new \Google_Client();
                $client->setAuthConfig(base_path('google_creds.json'));
                $client->setScopes([\Google_Service_Gmail::MAIL_GOOGLE_COM]);

                return $client;
            });
        }
    }
}
