<?php

use Masteryl\Modules\Teams\Controllers\TeamsController;

// check if teams is active and addon exists

$app->on('admin.api', [TeamsController::class, 'adminApi']);
$app->on('settings.controller', [TeamsController::class, 'settingsController']);
$app->on('collection', [TeamsController::class, 'collection']);
