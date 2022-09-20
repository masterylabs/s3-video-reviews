<?php

namespace Masteryl\Host;

class Host
{
    protected $app;

    protected $url;

    public function __construct($app)
    {
        $this->app = $app;

        $this->url = $app->host_url;
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
    }

    public function getUpdate()
    {
        if (!$this->url) {
            return false;
        }

        ee('getUpdate', $this->url);
    }

}
