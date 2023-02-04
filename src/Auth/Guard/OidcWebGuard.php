<?php

namespace Dsoloview\LaravelOIDC\Auth\Guard;

use Dsoloview\LaravelOIDC\Models\OidcUser;
use Dsoloview\LaravelOIDC\Oidc\AuthData;
use Dsoloview\LaravelOIDC\Oidc\OidcProvider;
use Dsoloview\LaravelOIDC\Oidc\OidcSessionService;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class OidcWebGuard implements Guard
{

    protected ?OidcUser $user = null;
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
        if (!isset($this->user)) {
            $user = $this->oidcProvider->authenticate();

            if ($user) {
                $this->setUser($user);
            }
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

        $user = $this->oidcProvider->authenticate();

        if ($user) {
            $this->setUser($user);
            return true;
        }
        return false;
    }

    public function hasUser()
    {
        return $this->check();
    }

    public function setUser(OidcUser|Authenticatable $user)
    {
        $this->user = $user;
    }
}
