<?php
// v1.0.1

use Masteryl\Modules\UserAuth\UserAuthMiddleware;

return [
    'settings' => [
        'middleware' => UserAuthMiddleware::class,
        'fields' => [
            'aws_access_key',
            'aws_secret',
        ],
    ],
];
