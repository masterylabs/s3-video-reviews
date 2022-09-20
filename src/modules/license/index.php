<?php

use Masteryl\Modules\License\License;

$app->que('license', function ($app) use ($options) {
    return new License($app, $options);
});
