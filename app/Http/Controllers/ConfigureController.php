<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfigureController extends Controller
{
	/**
	 * Store a new db connection in the session. Then middleware
	 * set this db connection by default
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return mixed
	 */
    public function changeDbConnection(Request $request)
    {
	    session(['dbConnection'=> $request->connectionName]);

    	return response()->json(session('dbConnection'));
    }
}
