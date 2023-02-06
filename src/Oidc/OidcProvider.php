<?php

namespace Dsoloview\LaravelOIDC\Oidc;


use Dsoloview\LaravelOIDC\Models\OidcUser;

class OidcProvider
{
    private OidcClient $oidc;

    public function __construct(OidcClient $oidc)
    {
        $this->oidc = $oidc;
    }

    public function getAuthLink(array $scopes = null): string
    {
        return $this->oidc->getAuthLink($scopes);
    }

    public function getAuthData(): AuthData
    {
        return $this->oidc->getToken();
    }

    public function refreshToken(string $refreshToken): AuthData
    {
        return $this->oidc->refreshToken($refreshToken);
    }

    public function authenticate(): ?OidcUser
    {
        $credentials = OidcSessionService::getCredentials();
        if (empty($credentials)) {
            return null;
        }

        $oidcUserId = $this->getOidcUserId($credentials);

        if (!$oidcUserId) {
            OidcSessionService::forgetCredentials();;
            return null;
        }

        $user = OidcUser::where('oidc_id', '=', $oidcUserId)->first();

        if (!$user) {
            $user = OidcUser::create(['oidc_id' => $oidcUserId]);
        }

        return $user;
    }

    // Get id from server
    public function getOidcUserId(array $credentials): ?string
    {
        $authData = new AuthData($credentials);

        if ($authData->tokenIsExpired()) {
            $authData = $this->refreshToken($authData->getRefreshToken());
        }

        $userInfo = $this->oidc->getUserInfo($authData->getAccessToken());

        return $userInfo['id'] ?? null;

    }

    // Get id from id_token
//    public function getOidcUserId(array $credentials): string
//    {
//        $authData = new AuthData($credentials);
//
//        if ($authData->tokenIsExpired()) {
//            $authData = $this->refreshToken($authData->getRefreshToken());
//        }
//
//        return $authData->getIdTokenPayload()['sub'];
//    }

}
