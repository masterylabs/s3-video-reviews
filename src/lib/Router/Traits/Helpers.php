<?php

namespace Masteryl\Router\Traits;

use Masteryl\Helpers\Inflect;

trait Helpers
{

    public function namespaceCallback($cb)
    {

        $appPath = $this->app->app_path;

        $at = strpos($cb, '@');

        if ($at !== false) {
            $append = substr($cb, $at);
            $filePath = substr($cb, 0, $at);
        } else {
            $filePath = $cb;
        }

        // prep namespace

        $cb = str_replace('/', '\\', $cb);

        $nsPrefix = $this->app->namespace;

        if (!$nsPrefix || strpos($cb, $nsPrefix) === 0) {
            $nsPrefix = '';
        } else {
            $nsPrefix = "{$nsPrefix}\\";
        }

        // ee($nsPrefix . $cb);
        // if ($ns && strpos($cb, $ns) !== 0) {
        //     $cb = "{$ns}\\{$cb}";
        // }

        $file = "{$appPath}/app/{$filePath}.php";

        // exit($file);

        if (file_exists($file)) {
            return $nsPrefix . $cb;
        }

        $arr = preg_split('/(?=[A-Z])/', $filePath);
        $dir = end($arr);

        $file = "{$appPath}/app/{$dir}/{$filePath}.php";

        if (file_exists($file)) {
            return $nsPrefix . $dir . '\\' . $cb;
        }

        /**
         * Plural
         */

        $dir = Inflect::pluralize($dir);

        $file = "{$appPath}/app/{$dir}/{$filePath}.php";

        if (file_exists($file)) {
            return $nsPrefix . $dir . '\\' . $cb;
        }

        /**
         * Not identified
         */

        return $cb;

    }
}
