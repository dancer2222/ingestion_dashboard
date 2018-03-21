<?php

namespace App\Http\Middleware;

use Closure;

class Brightcove
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
        if (!config('services.brightcove.client_id') || !config('services.brightcove.client_secret')) {
            logger()->error(
                'Brightcove: There are not client_id or client_secret in config.'
            );

            return redirect('/')->withErrors([
                'general' => 'Brightcove: There are not client_id or client_secret in config.',
            ]);
        }

        return $next($request);
    }
}
