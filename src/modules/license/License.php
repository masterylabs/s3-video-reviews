<?php

namespace Masteryl\Modules\License;

use Masteryl\Helpers\Encrypt;

class License
{
    protected $app;

    protected $options;

    protected $label;

    protected $access;

    public $valid;

    public function __construct($app, $options = [], $secret = null)
    {
        $this->app = $app;

        $this->options = $options;

        $value = $app->option('license')->get();

        if ($value) {
            if (!$secret) {
                $secret = $app->option('install_key')->get();
            }

            // ee($value);
            // return;

            $value = Encrypt::open($value, $secret);

            // ee([$value, $secret]);

            foreach ($value as $key => $val) {
                $this->{$key} = $val;
            }

            $this->label = $this->getLabel();

            if ($this->label) {
                $app->setProp('label', $this->label);
            }

        }
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        $load = 'load_' . $key;
        if (method_exists($this, $load)) {
            $this->{$load}();
            return $this->{$key};
        }
    }

    public function isValid()
    {
        return !empty($this->valid);
    }

    public function getAddons($na = [])
    {
        // ee('getAddons', $this->addons);
        return !empty($this->addons) ? $this->addons : $na;
    }

    public function getAccess()
    {
        if (!isset($this->access)) {
            $this->access = $this->getAddonsKeys();
        }
        return $this->access;
    }

    public function setAccess($arr = [])
    {
        ee('set access', $arr);
    }

    public function getAddonsKeys()
    {
        return array_map(function ($item) {
            return $item->value;
        }, $this->getAddons());
    }

    // public function load_access()
    // {
    //     $this->access = [];

    //     $addons = $this->getAddons(false);

    //     if ($addons) {
    //         $this->access = array_map(function ($item) {
    //             return $item['value'];
    //         }, $addons);
    //     }
    // }

    public function getLabel()
    {
        if (isset($this->label)) {
            return $this->label;
        }

        $addons = $this->getAddons(false);

        if (!$addons) {
            return false;
        }

        $values = array_map(function ($item) {
            return $item->value;
        }, $addons);

        $value = false;

        foreach ($this->options['label_hierarchy'] as $val) {
            if (in_array($val, $values)) {
                $value = $val;
            }
        }

        if (!$value) {
            return false;
        }

        // return value
        foreach ($addons as $addon) {

            if ($addon->value === $value) {
                $this->label = $addon->text;
                return $this->label;
            }
        }

    }

    public function hasAddon($key)
    {
        if (!$this->valid) {
            return false;
        }

        if (empty($key)) {
            return true;
        }

        $keys = $this->getAddonsKeys();

        return in_array($key, $keys);

    }

    public function hasAddons($arr)
    {
        if (!$this->valid) {
            return false;
        }

        if (empty($arr)) {
            return true;
        }

        $keys = $this->getAddonsKeys();

        foreach ($arr as $key) {
            if (!in_array($key, $keys)) {
                return false;
            }
        }
        return true;

    }

    public function hasAnyAddon($arr)
    {
        if (!$this->valid) {
            return false;
        }

        if (empty($arr)) {
            return true;
        }

        $keys = $this->getAddonsKeys();

        foreach ($arr as $key) {
            if (in_array($key, $keys)) {
                return true;
            }
        }
        return false;
    }
}
