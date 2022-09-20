<?php

namespace Masteryl\Helpers;

class FindFile
{
    /**
     * Lookfor a file or folder upstream from starting place, and return full path or false
     */
    public static function up($fileName, $na = false, $path = null)
    {
        if (!$path) {
            $path = substr(__DIR__, 0, -12);
        } else {
            $path = rtrim($path, '/');
        }

        while (strlen($path) > 1) {

            $file = "{$path}/{$fileName}";

            if (file_exists($file)) {
                return $file;
            }

            $n = strrpos($path, '/');
            $path = substr($path, 0, $n);

        }

        return $na;
    }
}
