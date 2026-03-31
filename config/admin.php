<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Admin dashboard (session) login
    |--------------------------------------------------------------------------
    |
    | Credentials for the /login form (AuthController). Set in .env; do not
    | commit real production secrets. For production, use strong values and
    | set ADMIN_SHOW_LOGIN_HINT=false (and APP_DEBUG=false).
    |
    */

    'email' => env('ADMIN_EMAIL', 'admin@malbis.local'),

    'password' => env('ADMIN_PASSWORD', 'MalbisAdmin2025'),

    /*
    | When true, the login page shows email/password (for local setup).
    | Defaults to APP_DEBUG so production with APP_DEBUG=false hides them.
    | Override with ADMIN_SHOW_LOGIN_HINT=true|false
    |
    */

    'show_credentials_on_login' => filter_var(
        env('ADMIN_SHOW_LOGIN_HINT', env('APP_DEBUG', false)),
        FILTER_VALIDATE_BOOLEAN
    ),

];
