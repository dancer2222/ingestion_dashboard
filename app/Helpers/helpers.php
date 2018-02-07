<?php

use Ingestion\Auth\Google\User;

if (! function_exists('getDbConnections')) {
	/**
	 * Get current database connection
	 *
	 * @return array
	 */
	function getDbConnections()
	{
		return array_keys(config('database.connections'));
	}

    /**
     * @param $headers
     *
     * @return string
     */
	function checkHeaders($headers)
    {
        try {
            return get_headers($headers)[13];
        } catch (Exception $exception) {
            return $exception->getMessage();
        }
    }
}

if (! function_exists('isAuth')) {
	/**
	 * Check if user has been stored in the session
	 *
	 * @return array
	 */
	function isAuth()
	{
		return session()->has('sessionUser');
	}
}

if (! function_exists('googleUser')) {
	/**
	 * Return the user was authenticated through google
	 *
	 * @return User
	 */
	function googleUser()
	{
		if (session()->has('sessionUser.user')) {
			return session('sessionUser.user');
		}
	}
}
