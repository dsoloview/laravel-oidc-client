<?php

return [
    'client_id' => env('OIDC_CLIENT_ID', ''),
    'client_secret' => env('OIDC_CLIENT_SECRET', ''),
    'redirect_url' => env('OIDC_REDIRECT_URL', ''),
    'authorization_url' => env('OIDC_AUTHORIZATION_URL', ''),
    'token_url' => env('OIDC_TOKEN_URL', '')
];