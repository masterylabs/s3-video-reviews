<?php

namespace Masteryl\Lang;

use Masteryl\Traits\GetFilesWithContent;

class Lang
{
    use GetFilesWithContent;

    protected $app;

    protected $lang = 'en';

    private $dirs = [];

    private $dirs_loaded = false;

    public function __construct($app)
    {
        $this->app = $app;
        // ee('app', $app->plugin_dir);
        $dir = $app->plugin_dir . '/lang';
        if (file_exists($dir)) {
            $this->addDir($dir);
        }
    }

    public function setLang($lang)
    {
        $this->lang = $lang;
    }

    public function addDir($path, $prefix = '')
    {
        $this->dirs[] = [
            'path' => $path,
            'prefix' => $prefix,
        ];
    }

    public function __get($key)
    {
        // ee('get');

        if (!$this->dirs_loaded) {
            $this->loadDirs();
        }

        if (isset($this->{$key})) {
            return $this->{$key};
        }

        // lang returns empty nothing
        return '';
    }

    public function get()
    {
        if (!$this->dirs_loaded) {
            $this->loadDirs();
        }

        return $this;
    }

    private function loadDirs()
    {
        foreach ($this->dirs as $dir) {
            $files = $this->getFilesWithContent($dir['path']);

            foreach ($files as $file) {
                $this->loadContents(trim($file['contents']), $dir['prefix']);
            }
        }

        $this->dirs_loaded = true;
        // ee('load lang', $this->dirs);
    }

    private function loadContents($contents, $prefix)
    {
        $rows = explode(PHP_EOL, $contents);

        $textBlock = null;

        foreach ($rows as $row) {
            $row = trim($row);

            if (empty($row) || in_array(substr($row, 0, 1), ['#', '<', '/', '*', '?'])) {
                continue;
            }

            if ($textBlock) {

                if (strpos($row, '}}') !== false) {
                    $row = trim($row);
                    if (strpos($row, '}}') !== 0) {
                        $textBlock[1] .= ltrim($row, '}}');
                    }
                    $key = $textBlock[0];
                    $this->{$key} = $textBlock[1];
                    unset($textBlock);
                    continue;
                }

                $textBlock[1] .= $row;
                continue;
                // ee('IN TEXT BLOCK', $row);
            }

            $sep = strpos($row, ' ');
            $key = substr($row, 0, $sep);

            $val = substr($row, $sep + 1);

            if (strpos($val, '{{') === 0) {
                $textBlock = [$key, ltrim($val, '{{')];
                continue;
            }

            $key = strtoupper($key);

            $this->{$key} = $val;
        }
    }

    /**
     * Magics
     */

    // public static function __callStatic($m, $args = [])
    // {
    //     $m = '_' . $m;
    //     return (new Lang)->{$m}(...$args);
    // }
}
