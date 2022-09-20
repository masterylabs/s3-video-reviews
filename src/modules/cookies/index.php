<?php

use Masteryl\Modules\Cookies\Cookies;

$app->que('cookies', function ($app) use ($options) {
    return new Cookies($app, $options);
});
