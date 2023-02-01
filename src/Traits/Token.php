<?php

namespace Dsoloview\LaravelOIDC\Traits;


use Dsoloview\LaravelOIDC\Exceptions\OidcException;
use Illuminate\Support\Facades\Session;

trait Token
{
    public function getToken(): void
    {
        $this->checkState();
        $this->checkCode();


        $queryParams = [
            'client_id' => $this->config->getClientId(),
            'code' => request()->get('code'),
            'grant_type' => 'authorization_code',
            'client_secret' => $this->config->getClientSecret(),
            'state' => $this->state,
            'redirect_uri' => $this->config->getRedirectUrl(),
            'scope' => $this->config->getScopesAsString(),
            'response_type' => 'code',
        ];


        $response = $this->httpClient->request('POST', $this->url->getTokenUrl(), [
            'form_params' => $queryParams
        ])->getBody();

        $json = json_decode($response, true);

        if (isset($json['error'])) {
            throw new OidcException($json['error_description']);
        }


        $payload = $this->jwtDecode($json['id_token']);

        dd($payload);

    }

    private function checkState()
    {
        if (!Session::has('oidc_state')) {
            throw new OidcException("Don't have state");
        }
        if (Session::get('oidc_state') !== request()->get('state')) {
            throw new OidcException("States mismatch");
        }
    }

    private function checkCode()
    {
        if (request()->missing('code')) {
            throw new OidcException('Code is not present');
        }
    }

    private function jwtDecode(string $token)
    {
        return json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $token)[1]))), true);
    }

}