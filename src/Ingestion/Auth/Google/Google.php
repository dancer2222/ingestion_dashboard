<?php

namespace Ingestion\Auth\Google;

use Exception;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;
use Google_Client;
use Google_Service_Oauth2;

class Google {

	/**
	 * @var \Google_Client
	 */
	private $client;

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $guzzle;

	/**
	 * @var \Illuminate\Http\Request
	 */
	private $request;

	/**
	 * @var string
	 */
	private $url;

	public function __construct(Google_Client $client, Guzzle $guzzle, Request $request) {
		$this->client = $client;
		$this->guzzle = $guzzle;
		$this->request = $request;
	}

	private function redirect()
	{
		return redirect($this->url);
	}

	public function auth()
	{
		$this->url = $this->client->createAuthUrl([
			Google_Service_Oauth2::PLUS_ME,
			Google_Service_Oauth2::USERINFO_EMAIL,
			Google_Service_Oauth2::USERINFO_PROFILE,
		]);

		return $this->redirect();
	}

	public function user()
	{
		try {
			$oauth = new Google_Service_Oauth2($this->client);

			return new User($oauth->userinfo_v2_me->get());

		} catch (Exception $e) {
			return [];
		}
	}
}