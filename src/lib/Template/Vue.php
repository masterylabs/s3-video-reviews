<?php

namespace Masteryl\Template;

/**
 * MasteryLabs Template engine
 */
class Vue
{

    protected $file;

    protected $args;

    protected $dir;

    protected $url;

    // private $app;

    public function __construct($app, $file, $args = [])
    {
        $file = str_replace('.', '/', $file);

        $this->url = dirname($app->public_url . '/' . $file);

        $this->file = $app->app_path . '/public/' . $file . '.html';

        $this->dir = dirname($this->file);

        $this->args = $args;

    }

    public function getHeaderScripts()
    {
        $template = $this->getTemplate();

        $start = strpos($template, '</title>') + 8;
        $end = strpos($template, '</head>');

        return trim(substr($template, $start, $end - $start));
    }

    public function render()
    {
        $template = $this->getTemplate();

        echo $template;
    }

    public function getTemplate()
    {
        $contents = file_get_contents($this->file);

        $contents = str_replace('="/', '="' . $this->url . '/', $contents);

        return $contents;
    }
}
