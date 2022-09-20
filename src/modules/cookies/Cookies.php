<?php

namespace Masteryl\Modules\Cookies;

class Cookies
{
    protected $app;

    protected $options;

    protected $default_expire;

    protected $default_path;

    public function __construct($app, $options = [])
    {
        $this->app = $app;

        $this->options = $options;

        $this->default_expire = time() + $options['default_expire_days'] * 86400;

        $this->default_path = $options['default_path'];

    }

    public function set($key, $value, $expire = null, $path = null)
    {
        if (headers_sent()) {
            return;
        }

        $key = $this->app->id . '_' . $key;

        if (!$expire) {
            $expire = $this->default_expire;
        }

        if (!$path) {
            $path = $this->default_path;
        }

        setcookie($key, $value, $expire, $path);

        // ee(['SET', $key, $value, $expire, $path]);
    }

    public function get($key, $fallback = false)
    {
        $key = $this->app->id . '_' . $key;

        if (!isset($_COOKIE[$key])) {
            return $fallback;
        }

        return $_COOKIE[$key];
    }
}
