<?php

use Masteryl\Modules\Brand\Controller;
use Masteryl\Modules\Settings\Extend;

$args = [
    'path' => $options['route_path'],
    'middleware' => $options['middleware'],
];

$router->api($args, function ($router) {
    $router->get('', Controller::class);
});

Extend::routes('brand', $router, $args);
