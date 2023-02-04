<?php

namespace Dsoloview\LaravelOIDC\Oidc;


class OidcProvider
{
    private OidcClient $oidc;

    public function __construct(OidcClient $oidc)
    {
        $this->oidc = $oidc;
    }

    public function getAuthLink(array $scopes = null): string
    {
        return $this->oidc->getAuthLink($scopes);
    }

    public function getAuthData(): AuthData
    {
       return $this->oidc->getToken();
    }

    public function refreshToken(string $refreshToken): AuthData
    {
        return $this->oidc->refreshToken($refreshToken);
    }

}
