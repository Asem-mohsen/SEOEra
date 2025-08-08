<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Scripts
    |--------------------------------------------------------------------------
    |
    | Define all JavaScript files needed for your site.
    |
    */

    'scripts' => [
        ['src' => 'assets/plugins/global/plugins.bundle.js'],
        ['src' => 'assets/js/scripts.bundle.js'],
    ],

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    |
    | Define default and directional (LTR/RTL) CSS files.
    |
    */

    'styles' => [
        'default' => [
            'assets/plugins/global/plugins.bundle.css',
            'assets/css/style.bundle.css',
            'assets/css/custom-style.css',
            'assets/css/toastr.min.css',
        ],
    ],

];
