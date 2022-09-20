<?php

use Masteryl\Modules\Login\Login;

$app->on('userAuth.unauthorized', [Login::class, 'unauthorized']);
$app->on('admin.api', [Login::class, 'adminApi']);

$router = $app->router;

$router->post('/api/login', [Login::class, 'login']);
