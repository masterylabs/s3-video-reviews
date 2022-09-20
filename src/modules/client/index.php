<?php

use Masteryl\Modules\Client\Client;

// Plugin activate
// ee($options);

$app->on('activate', function ($app) use ($options) {

    $client = new Client($app, $options);

    $res = $client->activate();

    if ($res->code >= 400) {
        echo !empty($res->body->message) ? $res->body->message : '';
        exit;
    }
});

// Plugin activate

$app->on('deactivate', function ($app) use ($options) {
    $client = new Client($app, $options);
    $client->deactivate();
});

// Que Props

$app->que('client', function ($app) use ($options) {
    return new Client($app, $options);
});
