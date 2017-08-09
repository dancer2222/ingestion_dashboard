<?php

namespace App\Http\Middleware;

use Closure;

class BrightcoveNotifications
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
        if ($request->get('accountId') == config('services.brightcove.account_id')) {
            return $next($request);
        }

        return response('Forbidden', 403);
    }
}
