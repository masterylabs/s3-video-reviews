<?php

use Masteryl\Modules\UserAuth\UserAuthMiddleware;
use S3VideoReviews\AdminApi;
use S3VideoReviews\Controllers\FileController;
use S3VideoReviews\Controllers\PageController;
use S3VideoReviews\Controllers\TemplateController;

$args = [
    'middleware' => UserAuthMiddleware::class,
];

$router->api($args, function ($router) {

    $router->get('/admin', [AdminApi::class, 'authenticated']);

    $router->get('/pages/name-exists', [PageController::class, 'nameExists']);
    $router->collection('page', ['pages']);

    $router->get('/templates/{template}', TemplateController::class);
    $router->get('/pages/{id}/files', FileController::class);
    $router->get('/pages/{id}/files/index', [FileController::class, 'indexPage']);

    $router->get('/pages/{id}/offer-file-names', [FileController::class, 'offerFileNames']);

    // dev
    $router->get('/pages/{id}/files/body', [FileController::class, 'body']);

});
