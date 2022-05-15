<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            if ($request->routeIs('owner.*')){
                return route('owner.login');
            }
            if ($request->routeIs('admin.*')){
                return route('admin.login');
            }
            if ($request->routeIs('secretary.*')){
                return route('secretary.login');
            }
            if ($request->routeIs('garagist.*')){
                return route('garagist.login');
            }
            return route('user.login');
        }
    }
}
