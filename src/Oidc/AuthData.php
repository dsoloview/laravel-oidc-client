<?php

namespace Dsoloview\LaravelOIDC\Oidc;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable;

class AuthData implements Arrayable
{
    private ?string $accessToken = null;
    private ?string $refreshToken = null;
    private ?string $idToken = null;

    private ?Carbon $expiredId = null;

    public function __construct(array $credentials = null)
    {
        if ($credentials) {
            $this->accessToken = $credentials['access_token'];
            $this->refreshToken = $credentials['refresh_token'];
            $this->idToken = $credentials['id_token'];
            $this->expiredId = Carbon::parse($credentials['id_token']['exp']);
        }
    }

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

    /**
     * @param Carbon|null $expiredId
     */
    public function setExpiredId(string $expiredId): void
    {
        $this->expiredId = Carbon::parse($expiredId);
    }

    public function getExpiredId(): ?Carbon
    {
        return $this->expiredId;
    }

    public function tokenIsExpired()
    {
        return $this->expiredId->isPast();
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

    public function toArray()
    {
        return [
            'access_token' => $this->accessToken,
            'refresh_token' => $this->refreshToken,
            'id_token' => $this->idToken
        ];
    }
}
