<?php

namespace Dsoloview\LaravelOIDC\Oidc;

class OidcUrl
{
    private string $providerUrl;
    private string $authUrl;
    private string $tokenUrl;

    private string $userInfoUrl;

    private const DISCOVER = '';

    public function __construct(bool $autoDiscover = true, string $providerUrl = null)
    {
        if ($autoDiscover && $providerUrl) {
            $this->providerUrl = $providerUrl;
            $this->autoDiscover();
        } else {
            $this->authUrl = config('oidc.authorization_url');
            $this->tokenUrl = config('oidc.token_url');
            $this->userInfoUrl = config('oidc.userinfo_url');
        }

    }

    private function autoDiscover()
    {

    }

    /**
     * @return string
     */
    public function getAuthUrl(): string
    {
        return $this->authUrl;
    }

    /**
     * @return string
     */
    public function getTokenUrl(): string
    {
        return $this->tokenUrl;
    }

    public function getUserInfoUrl(): string
    {
        return $this->userInfoUrl;
    }


}
