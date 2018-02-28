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
	public $client;

	/**
	 * @var \GuzzleHttp\Client
	 */
	private $guzzle;

	/**
	 * @var \Illuminate\Http\Request
	 */
	private $request;

    /**
     * Google constructor.
     * @param Google_Client $client
     * @param Guzzle $guzzle
     * @param Request $request
     */
	public function __construct(Google_Client $client, Guzzle $guzzle, Request $request) {
		$this->client = $client;
		$this->guzzle = $guzzle;
		$this->request = $request;
	}

    /**
     * @param string|array $token
     */
    public function setAccessToken($token)
    {
        $this->client->setAccessToken($token);
    }

    public function fetchAccessTokenWithAuthCode(string $authCode)
    {
        $accessToken = $this->client->fetchAccessTokenWithAuthCode($authCode);
        $this->setAccessToken($accessToken);
    }

    /**
     * @return array
     */
    public function getAccessCode()
    {
        return $this->client->getAccessToken();
    }


    /**
     * @return string
     */
	public function getAuthUrl(): string
	{

	    return $this->client->createAuthUrl();
	}

    /**
     * Get user
     *
     * @return array|User
     */
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