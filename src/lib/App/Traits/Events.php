<?php

namespace Masteryl\App\Traits;

trait Events
{
    private $_custom_events = [];

    public function on($name, $cb)
    {
        if ($name === 'activate') {
            return register_activation_hook($this->plugin_file, function () use ($cb) {
                $this->callFunction($cb);
            });
        }

        if ($name === 'deactivate') {
            return register_deactivation_hook($this->plugin_file, function () use ($cb) {
                $this->callFunction($cb);
            });
        }

        if ($name === 'logout') {
            return add_action('wp_logout', function ($userId) use ($cb) {
                $this->callFunction($cb, $userId);
            });
        }

        // Custom events
        // ee('ADD CUSTOM EVENT', $name);
        if (!isset($this->_custom_events[$name])) {
            $this->_custom_events[$name] = [];
        }

        array_push($this->_custom_events[$name], $cb);

        // ee($this->_custom_events);
    }

    public function callFunction($cb, $data = null)
    {
        call_user_func($cb, $this, $data);
    }

    // added 1.0.1: calls custom event
    public function call($name, $data = null)
    {
        // exists ?
        if (!isset($this->_custom_events[$name])) {
            return;
        }

        foreach ($this->_custom_events[$name] as $cb) {
            $this->callEvent($cb, $data);

            // if (is_string($cb)) {
            //     $this->callClass($cb, $data);
            //     continue;
            // }

        }
    }

    private function callEvent($cb, $data = null)
    {
        if (is_object($cb)) {
            call_user_func($cb, $this, $data);
            return;
        }

        // ee('callClass', [$name, $data]);
        if (is_string($cb)) {
            $class = new $cb($this);
            $class($data);
            return;
        }

        if (is_array($cb)) {
            $className = $cb[0];
            $method = $cb[1];
            $class = new $className($this);
            $class->{$method}($data);

        }

        // ee('call class', [$name, $data]);
    }

}
