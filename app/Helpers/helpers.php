<?php

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
