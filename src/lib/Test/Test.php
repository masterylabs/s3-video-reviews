<?php

namespace Masteryl\Test;

class Test
{
    protected $app;

    protected $req;

    protected $res;

    protected $options;

    public function __construct($app, $options)
    {
        $this->app = $app;

        $this->req = $app->request;

        $this->res = $app->response;

        $this->options = $options;

        // console($options, 'Test Options');
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if (isset($this->options[$key])) {
            return $this->options[$key];
        }

        return null;
    }

    public function __call($name, $args)
    {

        // Call Options
        if (isset($this->options[$name])) {
            return $this->options[$name];
        }

        return $args[0];
    }

    public function getOption($key, $na = '')
    {
        console($this->options);
        console($this->options[$key]);

        return isset($this->options[$key]) ? $this->options[$key] : $na;
    }

    // public function onComplete()
    // {

    // }
}
