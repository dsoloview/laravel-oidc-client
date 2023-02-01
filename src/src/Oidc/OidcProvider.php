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

    public function getAuthLink(array $scopes = null): string
    {
        return $this->oidc->getAuthLink($scopes);
    }

    final public function getToken(): AuthData
    {
       return $this->oidc->getToken();
    }

}
