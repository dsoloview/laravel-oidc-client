<?php

namespace Dsoloview\LaravelOIDC\Oidc;

use Dsoloview\LaravelOIDC\Oidc\Config\OidcConfig;
use Dsoloview\LaravelOIDC\Traits\Token;
use GuzzleHttp\Client;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class OidcClient
{
    use Token;

    private OidcConfig $config;
    private OidcUrl $url;
    private string $state;
    private Client $httpClient;
    private AuthData $authData;

    public function __construct()
    {
        $this->config = new OidcConfig();
        $this->url = new OidcUrl();
        $this->state = Str::random(40);

        $this->httpClient = new Client([
            'verify' => false
        ]);
    }

    public function getAuthLink(array $scopes = null): string
    {
        $this->config->setScopes($scopes);
        
        $params = [
            'response_type' => 'code',
            'redirect_uri' => $this->config->getRedirectUrl(),
            'client_id' => $this->config->getClientId(),
            'client_secret' => $this->config->getClientSecret(),
            'state' => $this->state,
            'scope' => $this->config->getScopesAsString()
        ];

        return $this->url->getAuthUrl(). "?" . http_build_query($params);
    }

}
