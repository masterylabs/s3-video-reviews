<?php

namespace Masteryl\Option;

use Masteryl\Helpers\Encode;

/**
 * Accepts and returns all formats, string, number, bools, json, array
 */
class Option
{
    protected $name;

    protected $value;

    protected $name_prefix = '_';

    protected $name_sep = '_';

    public function __construct($app, $key)
    {
        $this->name = $this->name_prefix . $app->id . $this->name_sep . $key;
    }

    public function get()
    {

        if (!isset($this->value)) {
            $this->value = $this->unparse(\get_option($this->name));
        }

        return $this->value;
    }

    public function set($value)
    {
        return $this->update($value);
    }

    public function update($value)
    {
        \update_option($this->name, $this->parse($value));
    }

    public function destroy()
    {
        \delete_option($this->name);
    }

    public function unparse($value)
    {
        return Encode::fromString($value);

    }

    public function parse($value)
    {
        return Encode::toString($value);
    }
}
