<?php

namespace Dsoloview\LaravelOIDC\Traits;

use Dsoloview\LaravelOIDC\Exceptions\OidcException;
use Dsoloview\LaravelOIDC\Oidc\AuthData;
use Dsoloview\LaravelOIDC\Oidc\OidcSessionService;

trait RefreshToken
{
    public function refreshToken(string $refreshToken): AuthData
    {
        $queryParams = [
            'client_id' => $this->config->getClientId(),
            'grant_type' => 'refresh_token',
            'client_secret' => $this->config->getClientSecret(),
            'refresh_token' => $refreshToken,
            'redirect_uri' => $this->config->getRedirectUrl(),
        ];

        $response = $this->httpClient->request('POST', $this->url->getTokenUrl(), [
            'form_params' => $queryParams
        ])->getBody();

        $json = json_decode($response, true);

        if (isset($json['error'])) {
            throw new OidcException($json['error_description']);
        }

        OidcSessionService::saveCredentials($json);
        $this->authData = new AuthData($json);

        return $this->authData;
    }
}