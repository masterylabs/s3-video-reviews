<?php

namespace Masteryl\Test;

use Masteryl\Helpers\Str;

class Commander
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;

        console('commander started...');
        echo "\n";

    }

    public function run($command, $options)
    {
        // console($command, 'Starting new test:', '', '', '=');
        console($command, 'Test: ');

        if (!empty($options)) {
            info($options, 'Options: ');
        }

        /**
         * Load TestCase
         */

        $class = 'Masteryl\\Tests\\' . Str::toCamel($command, true);

        $model = new $class($this->app, $options);

        $res = $model->handle();

        if (method_exists($model, 'onDone')) {
            $model->onDone();
        }

        // Responses
        if ($model->error) {
            error($model->error);
        }

        if ($model->success) {
            success($model->success);
        }

        if ($model->info) {
            info($model->info);
        }

        if ($model->console) {
            console($model->console, 'Console: ');
        }

        if (is_bool($res)) {
            if ($res) {
                success($command);
            } else {
                error($command);
            }
        }
    }

    public function runAll($options)
    {
        $dir = $this->app->plugin_dir . '/tests';

        $items = scandir($dir);

        foreach ($items as $file) {
            if (strpos($file, '.php') === false) {
                continue;
            }

            $name = substr($file, 0, -4);
            $command = Str::camelToSnake($name, '-');

            $this->run($command, $options);
            // success($name . ' ' . $command);

            echo "\n";
        }
        // warning('RUN ALL ' . $this->app->plugin_dir . '/tests ' . file_exists($this->app->plugin_dir . '/tests'));
    }
}
