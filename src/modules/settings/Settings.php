<?php

namespace Masteryl\Modules\Settings;

use Masteryl\Helpers\Str;
use Masteryl\Traits\Fields;

class Settings
{
    use Fields;

    protected $app;

    protected $options;

    protected $option_key;

    public function meta($key = false, $na = false)
    {
        if (empty($this->meta)) {
            return $na;
        }

        if ($key) {
            return isset($this->meta->{$key}) ? $this->meta->{$key} : $na;
        }

        return $this->meta;
    }

    public function __construct($app, $options, $key = 'settings', $config = null)
    {
        $this->app = $app;

        $this->options = $options;

        $this->option_key = '_' . $app->id . '_' . $key;

        if ($config) {
            foreach ($config as $key => $val) {
                $this->{$key} = $val;
            }
        }

        $fields = $options['fields'];

        $this->setupFields($fields);

        // $value = get_option($this->option_key);
        $value = $this->getOption();

        if ($value) {
            $this->loadFields($value);
        }

    }

    /**
     * Helper function to create other settings
     */
    public static function create($app, $fields, $key)
    {
        return new self($app, ['fields' => $fields], $key);
    }

    public function __get($key)
    {
        if (isset($this->{$key})) {
            return $this->{$key};
        }

        if (in_array($key, $this->_fields)) {

            return $this->getEmptyValue($key);
        }

    }

    // returns values and defaults on every field

    public function all()
    {
        $value = (object) [];

        foreach ($this->_fields as $key) {
            if (isset($this->{$key})) {
                $value->{$key} = $this->{$key};
            } else {
                $value->{$key} = $this->getEmptyValue($key);
            }
        }

        return $value;
    }

    public function __call($name, $args)
    {
        if (strpos($name, 'get') === 0) {
            $prop = Str::camelToSnake(substr($name, 3));

            if (isset($this->{$prop})) {
                return $this->{$prop};
            }

            if (!empty($args)) {
                return $args[0];
            }
        }
    }

    public function update($values)
    {
        return $this->set($values)->save();
    }

    public function set($key, $value = null)
    {
        if (is_array($key) || is_object($key)) {
            $this->loadFields($key);
        } elseif ($this->isField($key)) {
            $this->{$key} = $value;
        }

        return $this;
    }

    public function save()
    {
        $data = $this->getFieldsString();

        return $this->updateOption($data);
        // return update_option($this->option_key, $data);
    }

    public function destroy()
    {
        return $this->deleteOption();
        // return delete_option($this->option_key);
    }

    /**
     * Privates
     */

    protected function getOption()
    {
        return get_option($this->option_key);
    }

    protected function updateOption($data)
    {
        return update_option($this->option_key, $data);
    }

    protected function deleteOption()
    {
        return delete_option($this->option_key);
    }
}
