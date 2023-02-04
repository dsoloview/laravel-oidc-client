<?php

namespace Dsoloview\LaravelOIDC\Providers;

use Dsoloview\LaravelOIDC\Auth\Guard\OidcWebGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class LaravelProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/oidc.php' => config_path('oidc.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    public function register()
    {
        Auth::extend('oidc-guard', function ($app, $name, array $config) {
            return new OidcWebGuard(Auth::createUserProvider($config['provider']), $app->request);
        });
    }
}