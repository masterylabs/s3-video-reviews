<?php

use Masteryl\Modules\UserAuth\UserAuth;

$app->que('userAuth', function () use ($app, $options) {
    return new UserAuth($app, $options);
});

$app->on('logout', function ($app, $userId) {
    $app->userAuth->deleteToken($userId);
});
