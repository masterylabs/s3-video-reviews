<?php

use Masteryl\Modules\Client\Controllers\HostController;
use Masteryl\Modules\Client\Controllers\LicenseController;
use Masteryl\Modules\Client\Middleware\HostMiddleware;

$args = [
    'path' => 'client',
    'middleware' => $options['middleware'],
];

$router->api($args, function ($router) {
    $router->post('license', [LicenseController::class, 'update']);
    $router->post('license/delete', [LicenseController::class, 'destroy']);
});

/**
 * Host
 */

$args = [
    'path' => 'client/host',
    'middleware' => HostMiddleware::class,
];

$router->api($args, function ($router) {
    $router->get('lookup', [HostController::class, 'lookup']);
    $router->post('deactivate', [HostController::class, 'deactivate']);
    $router->post('process', [HostController::class, 'process']);
});
