<?php

namespace Dsoloview\LaravelOIDC\Traits;


use Dsoloview\LaravelOIDC\Exceptions\OidcException;
use Dsoloview\LaravelOIDC\Oidc\AuthData;
use Dsoloview\LaravelOIDC\Oidc\OidcSessionService;
use Illuminate\Support\Facades\Session;

trait Token
{
    private string $accessToken;
    private string $idToken;

    public function getToken(): AuthData
    {
        $this->checkCode();

        $queryParams = [
            'client_id' => $this->config->getClientId(),
            'code' => request()->get('code'),
            'grant_type' => 'authorization_code',
            'client_secret' => $this->config->getClientSecret(),
            'state' => $this->state,
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

    private function checkCode(): void
    {
        if (request()->missing('code')) {
            throw new OidcException('Code is not present');
        }
    }

}
