<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Ingestion\Auth\Google\Google;

/**
 * Class LoginSocialController
 *
 * @package App\Http\Controllers\Auth
 */
class LoginGoogleController extends Controller
{
    /**
	 * Redirect to Google auth
	 *
     * @param Google $google
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function login(Google $google)
	{
		// Redirect user
		return redirect($google->getAuthUrl() . '&hd=playster.com');
	}


    /**
     * Catch callback from Google after user has authenticated.
     * Save user data to session
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
	public function callback(Request $request, Google $google)
	{
		$user = $google->user();

		if ($user && $user->getDomain() === 'playster.com') {
		    $sessionData = [
		        'accessToken' => $google->getAccessCode(),
                'user' => $user,
            ];

			Session::put('sessionUser', $sessionData);

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