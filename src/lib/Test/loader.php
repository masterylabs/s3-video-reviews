<?php

use Masteryl\Test\Commander;

// Test Functions
include_once __DIR__ . '/helpers.php';
// include_once __DIR__ . '/commandor.php';

$config = [];

$options = [];

$command = null;

foreach ($argv as $index => $i) {
    if ($index === 0) {
        continue;
    }

    if (strpos($i, '--') === 0 && strpos($i, '=') !== false) {
        $ii = explode('=', $i);
        $key = substr(array_shift($ii), 2);
        $val = implode('=', $ii);
        $config[$key] = $val;
    } elseif (strpos($i, '-') === 0) {
        $key = substr($i, 1);
        $config[$key] = true;
    }

    // key value
    elseif (strpos($i, '=') !== false) {
        $ii = explode('=', $i);
        $key = array_shift($ii);
        $val = implode('=', $ii);
        $config[$key] = $val;
        $options[$key] = $val;
    } elseif (!$command) {
        $command = $i;
    } else {
        $options[$i] = true;
    }
}

/**
 * Load WP
 */
$wp_did_header = true;

if (isset($config['wpdir'])) {
    require_once $config['wpdir'] . '/wp-load.php';
} elseif (isset($config['entry'])) {
    require_once $config['entry'];
}

/**
 * Loadin Plugin to expose $app
 */

// is plugin
if (defined('WP_PLUGIN_DIR')) {
    include WP_PLUGIN_DIR . '/' . $config['slug'] . '/' . $config['slug'] . '.php';
}

// wp();

$commander = new Commander($app);

if (!$command || $command == 'all') {
    $commander->runAll($options);
} else {
    $commander->run($command, $options);
}

echo "\n";
exit;

// if (!$command) {
//     error('Missing command');
//     exit;
// }

// // if(isset($argv['']))
// // wp()
// console($argv, 'Argv');
// console($command, 'Command');

// console($config, 'Config: ');

// info($options, 'Options: ');

// /**
//  * Load TestCase
//  */

// $class = 'Masteryl\\Tests\\' . Str::toCamel($command, true);

// //warning($class);exit;

// $model = new $class($app, $options);

// $res = $model->handle();

// if (method_exists($model, 'onDone')) {
//     $model->onDone();
// }

// // Responses
// if ($model->error) {
//     error($model->error);
// }

// if ($model->success) {
//     success($model->success);
// }

// if ($model->info) {
//     info($model->info);
// }

// if ($model->console) {
//     console($model->console, 'Console: ');
// }

// if (is_bool($res)) {
//     if ($res) {
//         success();
//     } else {
//         error();
//     }
// }

echo "\n";
exit;
