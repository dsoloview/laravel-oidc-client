<?php

namespace Dsoloview\LaravelOIDC\Oidc;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\Pure;
use Maicol07\OpenIDConnect\Client;
use Maicol07\OpenIDConnect\UserInfo;

class OidcProvider
{
    private Client $oidc;

    #[Pure]
    public function __construct(Client $oidc)
    {
        $this->oidc = $oidc;
    }

    public function getAuthLink(): string
    {
        return $this->oidc->getAuthorizationUrl(state: csrf_token());
    }

    final public function getUserInfo(): UserInfo
    {
        $this->oidc->authenticate();
        return $this->oidc->getUserInfo();
    }

}