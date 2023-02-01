<?php

namespace Dsoloview\LaravelOIDC\Oidc;

use JetBrains\PhpStorm\Pure;

class OidcProvider
{
    private OidcClient $oidc;

    #[Pure]
    public function __construct(OidcClient $oidc)
    {
        $this->oidc = $oidc;
    }

    public function getAuthLink(): string
    {
        return $this->oidc->getAuthLink();
    }

    final public function getToken(): UserInfo
    {
        $this->oidc->getToken();
        return $this->oidc->getUserInfo();
    }

}