<?php
// added v1.0.1

namespace Masteryl\Controller;

abstract class Controller
{
    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }
    }
}
