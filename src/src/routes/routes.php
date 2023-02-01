<?php

use Dsoloview\LaravelOIDC\Controllers\OidcController;
use Illuminate\Support\Facades\Route;

Route::prefix('oidc')->controller(OidcController::class)->group(function () {
    Route::get('login', 'login')->name('oidc.login');
    Route::get('logout', 'logout')->name('oidc.logout');
    Route::any('callback', 'callback')->name('oidc.callback');
});
