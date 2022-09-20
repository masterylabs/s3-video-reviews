<?php

use Masteryl\Helpers\FindFile;
use Masteryl\Test\Commander;

include_once __DIR__ . '/../lib/Helpers/FindFile.php';

// Test Functions
include_once __DIR__ . '/helpers/message.php';
include_once __DIR__ . '/helpers/parse-command.php';

// tweak
// find wordpress dir

if (empty($config['wpdir'])) {
    $config['wpdir'] = FindFile::up('wordpress');

    if (!$config['wpdir']) {
        $config['wpdir'] = FindFile::up('wp');
    }

    if (!$config['wpdir']) {
        echo "ERROR: missing wpdir \n";
        exit;
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
