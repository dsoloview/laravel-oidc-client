<?php

namespace Dsoloview\LaravelOIDC\Providers;

use Illuminate\Support\ServiceProvider;

class LaravelProvider extends ServiceProvider
{
    public function boot(){
        $this->publishes([
            __DIR__.'/../config/oidc.php' => config_path('oidc.php'),
        ]);

        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
    }
}