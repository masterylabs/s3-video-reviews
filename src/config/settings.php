<?php

use Masteryl\Modules\UserAuth\UserAuthMiddleware;

return [
    'middleware' => UserAuthMiddleware::class,
    'fields' => [
        'aws_access_key',
        'aws_secret',
        'aws_region',
        'aws_cloudfront',
        'meta:object',
        'auto_thumbs:bool',
        'google_analytics',
        'fb_pixel',
        'cookies_notice_active:bool',
        'cookies_notice_text',
        'cookies_notice_btn_text',
    ],
];
