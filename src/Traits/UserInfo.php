<?php

namespace Dsoloview\LaravelOIDC\Traits;

use Dsoloview\LaravelOIDC\Exceptions\OidcException;

trait UserInfo
{
    public function getUserInfo(string $accessToken): array
    {
        $response = $this->httpClient->request('GET', $this->url->getUserInfoUrl(), [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
                'Accept' => 'application/json',
            ]
        ])->getBody();

        $json = json_decode($response, true);

        if (isset($json['error'])) {
            throw new OidcException($json['error_description']);
        }

        return $json;


    }
}