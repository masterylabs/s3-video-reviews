<?php

use S3VideoReviews\AdminFront;
use S3VideoReviews\Controllers\PreviewController;
use S3VideoReviews\Middleware\AdminMiddleware;

$router->get('/admin', AdminFront::class, AdminMiddleware::class);
$router->get('/admin/preview/{id}', PreviewController::class);
