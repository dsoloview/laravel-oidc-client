<?php

namespace Dsoloview\LaravelOIDC\Oidc;

class AuthData
{
    private ?string $accessToken = null;
    private ?string $refreshToken = null;
    private ?string $idToken = null;

    /**
     * @param string|null $idToken
     */
    public function setIdToken(string $idToken): void
    {
        $this->idToken = $idToken;
    }

    /**
     * @return string|null
     */
    public function getIdToken(): ?string
    {
        return $this->idToken;
    }

    public function getIdTokenPayload(): ?array
    {
        if  ($this->idToken) {
            return json_decode(base64_decode(str_replace('_', '/', str_replace('-', '+', explode('.', $this->idToken)[1]))), true);
        }
        return null;
    }

    /**
     * @param string|null $accessToken
     */
    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    /**
     * @return string|null
     */
    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    /**
     * @param string|null $refreshToken
     */
    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }
}
