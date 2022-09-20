<?php

use Masteryl\Modules\Settings\Settings;

$app->que('settings', function ($app) use ($options) {
    return new Settings($app, $options);
});
