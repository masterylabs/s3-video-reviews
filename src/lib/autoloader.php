<?php

use Masteryl\Helpers\Str;

if (!function_exists('ee')) {
    function ee()
    {};
}

if (!isset($args) || !isset($args['plugin_namespace'])) {
    die('Error: ml/ml.php missing required args');
}

spl_autoload_register(function ($class) use ($args) {

    // validate namespace

    $pluginNamespace = is_array($args) && !empty($args['plugin_namespace']) ? $args['plugin_namespace'] : false;

    $isPluginAppDir = $pluginNamespace && strpos($class, $pluginNamespace . '\\') === 0;

    if (strpos($class, 'Masteryl\\') !== 0 && !$isPluginAppDir) {
        return;
    }

    // support modules
    $baseDir = is_array($args) && !empty($args['plugin_dir']) ? $args['plugin_dir'] : __DIR__ . '/..';

    if (strpos($class, 'Masteryl\\Modules') === 0) {
        $len = strlen('Masteryl\\Modules') + 1;
        $path = explode('\\', substr($class, $len));
        $module = Str::camelToSnake(array_shift($path), '-');
        $file = $baseDir . '/modules/' . $module . '/' . implode('/', $path) . '.php';
        include_once $file;
        return;
    }

    if (strstr($class, 'Masteryl\\') == true) {
        $file = str_replace('\\', '/', $class);

        $n = strpos($file, '/');
        $file = substr($file, $n) . '.php';

        if (file_exists(__DIR__ . $file)) {
            include_once __DIR__ . $file;
            return;
        }

        // root dir
        $i = explode('/', $file);
        $i[1] = Str::camelToSnake($i[1], '-');
        // ee($i[1]);
        $rootFile = implode('/', $i);

        if (file_exists($baseDir . $rootFile)) {
            include_once $baseDir . $rootFile;
            return;
        }

    }

    if (strstr($class, $args['plugin_namespace'])) {
        $file = str_replace('\\', '/', $class);
        $n = strpos($file, '/');
        $file = $args['plugin_dir'] . '/app' . substr($file, $n) . '.php';

        if (file_exists($file)) {
            include_once $file;
            return;
        }

    }
});
