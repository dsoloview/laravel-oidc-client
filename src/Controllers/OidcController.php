<?php

namespace Dsoloview\LaravelOIDC\Controllers;

use Dsoloview\LaravelOIDC\Enums\Scope;
use Dsoloview\LaravelOIDC\Oidc\OidcProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class OidcController extends Controller
{
    protected OidcProvider $oidc;

    public function __construct(OidcProvider $oidc)
    {
        $this->oidc = $oidc;
    }

    public function login(): RedirectResponse
    {
        return redirect()->away($this->oidc->getAuthLink([Scope::openid, Scope::profile]));
    }

    public function callback(Request $request)
    {
        $authData = $this->oidc->getAuthData();

        if (Auth::validate($authData->toArray())) {
            return redirect()->intended('/home');
        }

        return redirect('/login');
    }

}
