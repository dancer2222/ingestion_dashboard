<?php

namespace Ingestion\Auth\Google;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;
use Google_Client;
use GuzzleHttp\Client as Guzzle;
use Illuminate\Http\Request;
use Google_Service_Oauth2;
use Google_Service_Directory;

class GoogleProvider extends ServiceProvider
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

		$this->config = config('services.google.secret_file');
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
	 * @throws \InvalidArgumentException
	 */
	public function register()
	{
		$this->app->singleton(Google::class, function ($app) {
			$gClient = new Google_Client();
            $gClient->setApplicationName('Ingestion Dashboard Api');

			$gClient->setRedirectUri(config('services.google.redirect_uri'));
			$gClient->setClientId(config('services.google.client_id'));
			$gClient->setClientSecret(config('services.google.client_secret'));

            $gClient->setScopes([
                Google_Service_Oauth2::PLUS_ME,
                Google_Service_Oauth2::USERINFO_EMAIL,
                Google_Service_Oauth2::USERINFO_PROFILE,
            ]);
            $gClient->setAccessType('offline');

			$guzzle = new Guzzle();
			$accessToken = [];

			if (session()->has('sessionUser.accessToken')) {
				if ($gClient->isAccessTokenExpired()) {
					$gClient->fetchAccessTokenWithRefreshToken($gClient->getRefreshToken());

					session(['sessionUser.accessToken' => $accessToken]);
				}

				$accessToken = $gClient->getAccessToken();
			} elseif ($app->request->has('code')) {
				$accessToken = $gClient->fetchAccessTokenWithAuthCode($app->request->get('code'));
			}

			if ($accessToken) {
				$gClient->setAccessToken($accessToken);
			}

			return new Google($gClient, $guzzle, $app->request);
		});
	}

	/**
	 * @inheritdoc
	 * @return array
	 */
	public function provides() {
		return [Google::class];
	}
}