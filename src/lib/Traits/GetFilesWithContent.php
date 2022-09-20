<?php

namespace Masteryl\Traits;

trait GetFilesWithContent
{
    public static function getFilesWithContent($dir)
    {
        $items = scandir($dir);

        $files = [];

        foreach ($items as $item) {

            $file = $dir . '/' . $item;

            if (is_file($file)) {

                $name = strtok($item, '.');
                $contents = file_get_contents($file);
                $fileName = $item;

                $files[] = compact('name', 'file', 'fileName', 'contents');
            }
        }

        return $files;
    }
}
