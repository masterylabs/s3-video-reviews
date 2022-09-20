<?php

namespace S3VideoReviews;

use Masteryl\App\App;
use S3VideoReviews\Admin;

$args = [
    'plugin_namespace' => __NAMESPACE__,
    'plugin_dir' => substr(__DIR__, 0, -10),
    'plugin_file' => $pluginFile,
];

include_once __DIR__ . '/../lib/autoloader.php';

$app = App::create($args);

$app->canUpdate();

// Enable WP Update
$app->on('activate', function ($app) {
    $app->migrate();
});

// Enable models
$app->useModels();

// Modules
// $app->module('cookies');
$app->module('user-auth');
$app->module('license');
$app->module('client');
$app->module('access');
$app->module('settings');
$app->module('brand');

$app->module('user');

$app->loader->menuPage(Admin::class);

$router = $app->router;

// $app->router->allowCors();
// api must be before web
include_once __DIR__ . '/../routes/api.php';
include_once __DIR__ . '/../routes/web.php';

add_action('plugins_loaded', [$app, 'run']);
