<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Available themes (public site)
    |--------------------------------------------------------------------------
    | Each theme has: name (label in dashboard), views (Blade path), assets (public path).
    | Select active theme in Dashboard → Settings → General.
    */

    'default' => [
        'name'   => 'Default',
        'views'  => 'themes.default',
        'assets' => 'themes/default',
    ],

    'lovable' => [
        'name'   => 'Lovable',
        'views'  => 'themes.lovable',
        'assets' => 'themes/lovable',
    ],

];
