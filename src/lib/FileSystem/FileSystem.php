<?php

namespace Masteryl\FileSystem;

use Masteryl\Traits\GetFilesWithContent;

class FileSystem
{
    use GetFilesWithContent;

    // public static function getFilesWithContent($dir)
    // {
    //     $items = scandir($dir);

    //     $files = [];

    //     foreach ($items as $item) {

    //         $file = $dir . '/' . $item;

    //         if (is_file($file)) {

    //             $name = strtok($item, '.');
    //             $contents = file_get_contents($file);

    //             $files[] = compact('name', 'file', 'contents');
    //         }
    //     }

    //     return $files;
    // }

    public static function getFileNames($dir, $includeOnce = false)
    {

        if (!file_exists($dir)) {
            return false;
        }

        $items = scandir($dir);

        $files = [];

        foreach ($items as $item) {
            if (is_file("{$dir}/$item")) {
                if ($includeOnce) {
                    include_once "{$dir}/$item";
                }
                $files[] = $item;
            }
        }

        return $files;
    }

    public static function getConfigFiles($dir, $trimKeys = '.')
    {
        if (!file_exists($dir)) {
            return false;
        }

        $items = scandir($dir);

        $files = [];

        foreach ($items as $item) {
            $file = $dir . '/' . $item;
            if (is_file($file)) {

                if ($trimKeys) {
                    $item = strtok($item, $trimKeys);
                }

                $files[$item] = include $file;
            }
        }

        return $files;
    }
}
