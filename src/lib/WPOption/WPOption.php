<?php

namespace Masteryl\WPOption;

use Masteryl\Traits\LoadFills;

class WPOption
{
    use LoadFills;

    protected $app;

    protected $option_name;

    protected $db_key;

    protected $fillable = [];

    protected $default_values = [];

    protected $json_cols;

    protected $bool_cols;

    private $db_data;

    protected $key_prefix = '_';

    protected $key_sep = '_';

    // protected $hidden = [];

    // protected $json_cols = [];

    // protected $array_cols = [];

    // protected $int_cols = [];

    // protected $float_cols = [];

    // protected $bool_cols = [];

    public function __construct($app, $key = false)
    {
        $this->app = $app;

        if (!$this->db_key) {
            $this->db_key = $this->key_prefix . $app->id;

            if ($key) {
                $this->db_key .= $this->key_prefix . $key;
            } elseif ($this->option_name) {
                $this->db_key .= $this->key_prefix . $this->option_name;
            }
        }

        // ee('db_key', $this->db_key);

        if (!empty($app->config[$key])) {
            $this->setup($app->config[$key]);
        }

        $this->loadFills();

    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if (!$this->db_data) {
            $this->get();
        }
        ee('__get', $key);
    }

    /**
     * Returns data as array without class
     */

    public function getData($empty = [])
    {
        if (!$this->db_data) {
            $this->get();
        }

        return !empty($this->db_data) ? $this->db_data : $empty;

    }

    public function setData($value = [])
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        $this->setOption($value);
    }

    public function get()
    {
        if ($this->db_data) {
            return $this;
        }

        if (!empty($this->default_values)) {
            foreach ($this->default_values as $key => $val) {
                $this->{$key} = $val;
            }
        }

        $res = $this->getOption();

        if ($res) {
            $this->db_data = json_decode($res, true);

            foreach ($this->db_data as $key => $val) {
                $this->{$key} = $val;
            }

        } else {
            $this->db_data = [];
        }

        return $this;
    }

    public function save()
    {
        if (!$this->db_data) {
            $this->get();
        }

        foreach ($this->fillable as $key) {
            if (isset($this->{$key})) {
                $this->db_data[$key] = $this->{$key};
            }
        }

        $value = json_encode($this->db_data);

        $this->setOption($value);

    }

    public function update($args)
    {
        if (!$this->db_data) {
            $this->get();
        }

        foreach ($args as $key => $val) {
            if (in_array($key, $this->fillable)) {
                $this->{$key} = $val;
            }
        }

        $this->save();
    }

    private function setup($config)
    {
        foreach ($config as $key => $val) {

            if (is_string($key)) {
                $this->fillable[] = $key;
                $this->default_values[$key] = $val;
                continue;
            }

            if (is_array($val)) {
                $this->fillable[] = $val['key'];

                if (!empty($val['type'])) {
                    $this->addTypeCol($val['key'], $val['type']);
                }

                if (!empty($val['default_value'])) {
                    $this->addDefaultValue($val['key'], $val['default_value']);
                }

                continue;
            }

            $this->fillable[] = $val;
        }

    }

    private function getOption()
    {
        return get_option($this->db_key);
    }

    private function setOption($value)
    {
        update_option($this->db_key, $value);
    }

    private function addDefaultValue($key, $value)
    {
        if (!isset($this->default_values)) {
            $this->default_values = [];
        }
        $this->default_values[$key] = $value;

    }

    private function addTypeCol($key, $type)
    {
        $k = "{$type}_cols";
        if (!isset($this->{$k})) {
            $this->{$k} = [];
        }
        $this->{$k}[] = $key;
    }

}
