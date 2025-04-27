<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | These settings determine which cross-origin requests your API will
    | respond to from browsers.
    |
    */

    // Which paths should be CORS accessible
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    // Allowed HTTP methods
    'allowed_methods' => ['*'],

    // Your front-end origin (or use '*' to allow any in dev)
    'allowed_origins' => ['http://localhost:5173'],

    // Patterns to match origins (leave empty for none)
    'allowed_origins_patterns' => [],

    // Allowed request headers
    'allowed_headers' => ['*'],

    // Headers browsers can access
    'exposed_headers' => [],

    // How long the preflight result can be cached (seconds)
    'max_age' => 0,

    // Whether to expose credentials (cookies).
    // false if you’re using Bearer tokens, true if you need cookies.
    'supports_credentials' => false,

];
