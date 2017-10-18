<?php

namespace App\Http\Middleware;

use Closure;

class DatabaseConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
	    $defaultDbConnection = config('database.default');
	    $allowableDbConnections = array_keys(config('database.connections'));
	    $dbConnection = session()->get('dbConnection');

	    if (!in_array($dbConnection, $allowableDbConnections, true)) {
		    $dbConnection = $defaultDbConnection;
	    }

        config(['database.default' => $dbConnection]);

        return $next($request);
    }
}
