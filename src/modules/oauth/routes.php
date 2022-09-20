<?php

$router->group(['path' => 'auth'], function ($router) {
    $router->get('authorize');
});
