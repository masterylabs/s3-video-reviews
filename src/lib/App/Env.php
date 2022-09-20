<?php

namespace Masteryl\App;

class Env
{
    public function __construct($path, $fileName = '.env')
    {

        // ee('$path', $path);
        $path = rtrim($path, '/');

        while (strlen($path) > 1) {

            $file = "{$path}/{$fileName}";

            if (file_exists($file)) {
                $data = file_get_contents($file);
                break;
            }

            // ee($file);

            $n = strrpos($path, '/');
            $path = substr($path, 0, $n);
        }

        if (!isset($data)) {
            return;
        }

        // load env args

        $rows = explode(PHP_EOL, trim($data));

        foreach ($rows as $row) {
            $pos = strpos($row, '=');
            if ($pos === false || strpos($row, '#') === 0) {
                continue;
            }

            $key = trim(substr($row, 0, $pos));
            $val = trim(substr($row, $pos + 1));

            $this->{$key} = $val;

        }
    }

    public function __get($key)
    {
        // support lower case calls
        $u = strtoupper($key);
        if (isset($this->{$u})) {
            return $this->{$u};
        }
    }

    public function has($key)
    {
        $lower = strtolower($key);
        ee(['has', $key], $lower);
        return true;

        return isset($this->{$key}) || isset($this->{$lower});
    }
}
