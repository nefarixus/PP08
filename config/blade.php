<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Blade View Components
    |--------------------------------------------------------------------------
    |
    | This option allows you to register a custom component namespace that will
    | be used when defining components in your Blade views. By default, the
    | `App\View\Components` namespace is used for all components.
    |
    */

    'components' => [
        'namespace' => 'App\\View\\Components',
    ],

    /*
    |--------------------------------------------------------------------------
    | Compile Blade Templates On Every Request
    |--------------------------------------------------------------------------
    |
    | By default, Blade templates are compiled only when they have not already
    | been compiled or the source code has changed. However, you may enable
    | "debug mode" which will compile the templates on every request.
    |
    */

    'debug_mode' => env('APP_DEBUG', false),

];