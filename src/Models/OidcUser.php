<?php

namespace Dsoloview\LaravelOIDC\Models;

use Illuminate\Foundation\Auth\User;

class OidcUser extends User
{
    protected $fillable = [
      'oidc_id'
    ];

}