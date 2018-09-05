<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;
use Exception;

class SocialController extends Controller
{
    /**
     * @param string $provider
     * @return mixed
     */
    public function redirectToProvider(string $provider)
    {
        return Socialite::with($provider)->redirect();
    }

    /**
     * @param string $provider
     * @return $this|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback(string $provider)
    {
        try {
            $socialUser = Socialite::with($provider)->user();

            if (!$socialUser || !$socialUser->email) {
                throw new Exception("Sorry we have some problems with this kind of authentication. Please try log in using your credentials.");
            }

            $user = User::whereEmail($socialUser->email)->first();

            if (!$user || !Auth::login($user)) {
                throw new Exception("Sorry, we can't find the user with this e-mail: $socialUser->email");
            }
        } catch (Exception $e) {
            return redirect('/login')->withErrors([
                'any' => $e->getMessage(),
            ]);
        }

        return redirect('/');
    }
}
