<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        $routeLogin = str_contains($request->route()->getName(), 'admin')
            ? 'admin.login' : 'user.login';

        return $request->expectsJson() ? null : route($routeLogin, ['redirect' => $request->fullUrl()]);
    }
}
