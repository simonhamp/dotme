<?php

return [

    'use_authenticated' => false,

    'user' => [
        'name' => env('GITAMIC_GIT_USER_NAME', env('STATAMIC_GIT_USER_NAME')),
        'email' => env('GITAMIC_GIT_USER_EMAIL',  env('STATAMIC_GIT_USER_EMAIL')),
    ],

    'cache' => [
        'ttl' => 300,
    ]

];
