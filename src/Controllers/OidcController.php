<?php

namespace Dsoloview\LaravelOIDC\Controllers;

use Dsoloview\LaravelOIDC\Oidc\OidcProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class OidcController extends Controller
{
    private OidcProvider $oidc;
    public function __construct(OidcProvider $oidc)
    {
        $this->oidc = $oidc;
    }

    public function login(): RedirectResponse
    {
        return redirect()->away($this->oidc->getAuthLink());
    }

    public function callback()
    {
        dd($this->oidc->getUserInfo());
    }

}