<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Ingestion\Auth\Google\Google;

/**
 * Class LoginSocialController
 *
 * @package App\Http\Controllers\Auth
 */
class LoginGoogleController extends Controller {

	/**
	 * Redirect to Google auth
	 *
	 * @param \Ingestion\Auth\Google\Google $google
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function login(Google $google)
	{
		// Redirect user
		return $google->auth();
	}


	/**
	 * Catch callback from Google after user has authenticated.
	 * Save user data to session
	 *
	 * @param \Ingestion\Auth\Google\Google $google
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function callback(Google $google)
	{
		$user = $google->user();

		if ($user && $user->getDomain() === 'playster.com') {
			Session::put('sessionUser', $user);

			return redirect('/');
		}

		return redirect('/login');
	}

	/**
	 * Remove user data from session and redirect to /login
	 *
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function logout()
	{
		session()->forget('sessionUser');

		return redirect('/login');
	}
}