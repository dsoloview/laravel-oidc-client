<?php

namespace Dsoloview\LaravelOIDC\Oidc\Config;

use Dsoloview\LaravelOIDC\Enums\Scope;
use Dsoloview\LaravelOIDC\Exceptions\OidcConfigException;
use Pavelrockjob\Esia\Enums\EsiaScope;

class OidcConfig
{
    private string $providerUrl;
    private string $clientId;

    private string $clientSecret;
    private string $redirectUrl;
    private array $scopes = [Scope::openid];

    public function __construct()
    {
        $this->providerUrl = config('oidc.provider_url');
        $this->clientId = config('oidc.client_id');
        $this->clientSecret = config('oidc.client_secret');
        $this->redirectUrl = config('oidc.redirect_url');
    }

    public function setScopes(array $scopes = null): void
    {
        if ($scopes) {
            $this->checkScopes($scopes);
            $this->scopes = $scopes;
        }
    }

    private function checkScopes(array $scopes): void
    {
        foreach ($scopes as $scope) {
            if  (!($scope instanceof Scope)) {
                throw new OidcConfigException("Wrond scope format " . $scope);
            }
        }
    }

    /**
     * @return string
     */
    public function getProviderUrl(): string
    {
        return $this->providerUrl;
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @return string
     */
    public function getRedirectUrl(): string
    {
        return $this->redirectUrl;
    }

    /**
     * @return array
     */
    public function getScopes(): array
    {
        return $this->scopes;
    }

    public function getScopesAsString(): string
    {
        $scopes = [];
        foreach ($this->scopes as $scope){
            $scopes[] = $scope->name;
        }
        return join(' ', $scopes);
    }


}
