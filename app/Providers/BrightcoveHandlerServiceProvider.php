<?php

namespace App\Providers;

use Brightcove\API\Client;
use Brightcove\API\Exception\AuthenticationException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Ingestion\Brightcove\BrightcoveHandler;
use Ingestion\Brightcove\Api\CMS;

class BrightcoveHandlerServiceProvider extends ServiceProvider
{
    /**
     * @var bool
     */
    protected $defer = true;

    /**
     * The session instance
     *
     * @var mixed
     */
    protected $session;

    /**
     * Credentials to access to brightcove
     *
     * @var mixed
     */
    protected $config;

    /**
     * BrightcoveHandlerServiceProvider constructor.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(BrightcoveHandler::class, function ($app) {
            $this->config = config('services.brightcove');
            $this->session = $app->make('session');
            $client = $this->getClient();

            $cms = new CMS($client, $this->config['account_id']);

            return new BrightcoveHandler($cms, app('request'));
        });
    }

    /**
     * Returns Client instance
     *
     * @return Client
     * @throws \Brightcove\API\Exception\AuthenticationException
     */
    private function getClient(): Client
    {
        // Check if we already have the token in the session and if it isn't expired
        if ($this->checkIfTokenExpires()) {
            $client = Client::authorize($this->config['client_id'], $this->config['client_secret']);
            $tokenExpires = (int)$client->getExpiresIn();

            // When we were authorized we put the token and its expiry time in the session
            // to avoid the authorizing on each request
            $this->session->put('brightcove', [
                'accessToken' => $client->getAccessToken(),
                'tokenExpires' => time() + $tokenExpires,
                'realExpires' => $tokenExpires
            ]);
        } else {
            // Make a new client from data of session
            $client = new Client(
                $this->getToken(),
                $this->getRealExpires()
            );
        }


        return $client;
    }

    /**
     * Returns true if token is expired, remove the old token and expires from session.
     * Otherwise returns false
     *
     * @return bool
     */
    private function checkIfTokenExpires(): bool
    {
        if (!$this->session->has('brightcove.tokenExpires') || time() >= $this->session->get('brightcove.tokenExpires')) {
            $this->session->forget('brightcove');

            return true;
        }

        return false;
    }

    /**
     * Returns access token
     *
     * @return string Access token
     */
    private function getToken()
    {
        return $this->session->get('brightcove.accessToken');
    }

    /**
     * @return int Real expires time
     */
    private function getRealExpires()
    {
        return $this->session->get('brightcove.realExpires');
    }

  /**
   * @inheritdoc
   * @return array
   */
    public function provides() {
      return [BrightcoveHandler::class];
    }
}
