<?php

namespace Dsoloview\LaravelOIDC\Middleware;

use Illuminate\Auth\Middleware\Authenticate;

class OidcAuthenticated extends Authenticate
{
    protected function redirectTo($request)
    {
        return route('oidc.login');
    }
}