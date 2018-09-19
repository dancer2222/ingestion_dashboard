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
	 * @return bool
	 */
	function isAuth()
	{
		return session()->has('sessionUser');
	}
}

if (! function_exists('getUser')) {
	/**
	 * Return the user was authenticated through google
	 *
	 * @return User
	 */
	function getUser()
	{
		if (session()->has('sessionUser.user')) {
			return session('sessionUser.user');
		}

		return auth()->user();
	}
}

if (! function_exists('urlLastItem')) {
    /**
     * Return the last segment of url
     *
     * @return string
     */
    function urlLastItem()
    {
        return request()->segment(count(request()->segments()));
    }
}

if (! function_exists('ida_route')) {

    /**
     * Secure route if the environment isn't local
     *
     * @param string $name
     * @param array $params
     * @return string
     */
    function ida_route(string $name, array $params = [])
    {
        if (app()->isLocal()) {
            return route($name, $params);
        }

        return secure_url(route($name, $params, false));
    }
}

if (! function_exists('ida_asset')) {

    /**
     * Secure route if the environment isn't local
     *
     * @param string $path
     * @return string
     */
    function ida_asset(string $path)
    {
        return asset($path, !app()->isLocal());
    }
}

if (! function_exists('resizer')) {

    /**
     * @param array $parts
     * @param string $width
     * @param string $height
     * @return bool|string
     */
    function resizer(array $parts = [], string $width = '200', string $height = '300')
    {
        $env = env('APP_ENV') === 'local' ? 'qa' : env('APP_ENV');
        $urlBase = config("main.links.resizer.$env");

        foreach ($parts as $part) {
            $urlBase .= '/' . strtolower($part);
        }

        $url = sprintf('%s.jpg?m=w%s-h%s-cscale',
            $urlBase,
            $width,
            $height
        );

        $headers = get_headers($url);

        if (isset($headers[0]) && $headers[0] === 'HTTP/1.1 200 OK') {
            return $url;
        }

        return false;
    }
}
