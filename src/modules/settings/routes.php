<?php

use Masteryl\Modules\Settings\Controller;

$args = [
    'path' => $options['route_path'],
    'middleware' => $options['middleware'],
];

$router->api($args, function ($router) {
    $router->get('', [Controller::class, 'index']);
    $router->post('', [Controller::class, 'update']);
    $router->post('delete', [Controller::class, 'destroy']);
});
