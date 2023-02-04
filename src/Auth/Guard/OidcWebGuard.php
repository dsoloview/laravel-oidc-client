<?php

namespace Dsoloview\LaravelOIDC\Auth\Guard;

use Dsoloview\LaravelOIDC\Models\OidcUser;
use Dsoloview\LaravelOIDC\Oidc\AuthData;
use Dsoloview\LaravelOIDC\Oidc\OidcProvider;
use Dsoloview\LaravelOIDC\Oidc\OidcSessionService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

class OidcWebGuard implements Guard
{

    protected Authenticatable|User $user;
    protected UserProvider $provider;

    protected OidcProvider $oidcProvider;
    protected Request $request;

    public function __construct(UserProvider $provider, Request $request)
    {
        $this->provider = $provider;
        $this->request = $request;
        $this->oidcProvider = app(OidcProvider::class);
    }

    public function check()
    {
        return $this->user() !== null;
    }

    public function guest()
    {
        return !$this->check();
    }

    public function user()
    {
        if (empty($this->user)) {
            $this->authenticate();
        }

        return $this->user;
    }

    public function id()
    {
        return $this->check()
            ? $this->user->id
            : null;
    }

    public function validate(array $credentials = [])
    {
        if (empty($credentials['access_token']) || empty($credentials['id_token'])) {
            return false;
        }

        return $this->authenticate();
    }

    public function hasUser()
    {
        return $this->check();
    }

    public function setUser(Authenticatable $user)
    {
        $this->user = $user;
    }

    public function authenticate()
    {
        $credentials = OidcSessionService::getCredentials();
        if (empty($credentials)) {
            return false;
        }

        $oidcUserId = $this->getOidcUserId($credentials);

        if (!$oidcUserId) {
            OidcSessionService::forgetCredentials();;
            return false;
        }

        $user = OidcUser::where('oidc_id', '=', $oidcUserId)->first();

        if (!$user) {
            $user = OidcUser::create(['oidc_id' => $oidcUserId]);
        }
        $this->setUser($user);

        return true;
    }

    public function getOidcUserId(array $credentials): string
    {
        $authData = new AuthData($credentials);

        if ($authData->tokenIsExpired()) {
            $authData = $this->oidcProvider->refreshToken($authData->getRefreshToken());
        }

        return $authData->getExpiredId()['sub'];

    }
}