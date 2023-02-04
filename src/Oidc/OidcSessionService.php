<?php

namespace Dsoloview\LaravelOIDC\Oidc;


use Illuminate\Support\Facades\Session;

class OidcSessionService
{
    public static function getCredentials(): ?array
    {
        return Session::get('oidc_data');
    }

    public static function saveCredentials(array $credentials):void
    {
        Session::put('oidc_data', $credentials);
    }

    public static function forgetCredentials()
    {
        Session::forget('oidc_data');
    }
}