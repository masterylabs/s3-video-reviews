<?php

use Masteryl\Modules\Brand\Brand;

if (!$app->license->hasAnyAddon($options['require_addons'])) {
    return;
}

$app->brand = new Brand($app, $options, true);
