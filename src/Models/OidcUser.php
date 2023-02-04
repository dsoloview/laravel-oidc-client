<?php

namespace Dsoloview\LaravelOIDC\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class OidcUser extends Model
{
    use Authenticatable;

    protected $fillable = [
      'oidc_id'
    ];

}