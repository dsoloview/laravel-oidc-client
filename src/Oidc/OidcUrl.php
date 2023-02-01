<?php

namespace Dsoloview\LaravelOIDC\Oidc;

class OidcUrl
{
    private string $providerUrl;
    private string $authUrl;
    private string $tokenUrl;

    private const DISCOVER = '';

    public function __construct(bool $autoDiscover = true, string $providerUrl = null)
    {
        if ($autoDiscover && $providerUrl) {
            $this->providerUrl = $providerUrl;
            $this->autoDiscover();
        } else {
            $this->authUrl = config('oidc.auth_url');
            $this->tokenUrl = config('oidc.token_url');
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


}