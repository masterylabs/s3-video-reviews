<?php

use Masteryl\Modules\Access\Access;

$app->que('access', function ($app) use ($options) {
    return new Access($app, $options);
});
