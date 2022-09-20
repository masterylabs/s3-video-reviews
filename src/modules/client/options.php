<?php

use Masteryl\Modules\UserAuth\UserAuthMiddleware;

return [
    // 'host_api' => 'http://api-v3.test',
    'host_api' => 'https://api-v3-beta.masterylabs.com',
    'middleware' => UserAuthMiddleware::class,
    'bloginfo' => [
        'name',
        'description',
        'wpurl',
        'url',
        'admin_email',
        'admin_url',
        'language',
    ],
    'license' => [
        'label_hierarchy' => [
            'review',
            'unlimited',
            'premium',
            'developer',
            'agency',
            'wl',
            'res',
        ],
    ],
    'header_keys' => [
        'data' => 'X-Data',
        'install' => 'X-Install',
        'auth' => 'X-Auth',
    ],
];
