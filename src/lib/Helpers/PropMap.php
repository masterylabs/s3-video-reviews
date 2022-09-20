<?php

namespace Masteryl\Helpers;

class PropMap
{
    protected $body;

    protected $map;

    public function __construct($body, $map)
    {
        $this->body = $body;

        $this->map = $map;

        foreach ($map as $key => $val) {
            $value = $this->mapValue($val);

            if ($key === 'first_name' && $val === 'name') {
                $value = $this->getFirstName($value);
            } elseif ($key === 'last_name' && $val === 'name') {
                $value = $this->getLastName($value);
            }

            $this->{$key} = $value;
        }

        // ee($this);
    }

    public function getFirstName($name)
    {
        $i = explode(' ', $name);
        return array_shift($i);
    }

    public function getLastName($name)
    {
        $n = strpos($name, ' ');

        if ($n === false) {
            return '';
        }

        return substr($name, $n + 1);
    }

    public function mapValue($val)
    {

        $item = $this->body;

        $path = explode('>', $val);

        foreach ($path as $key) {

            if (strpos($key, '[') !== false) {

                $value = $this->parseSquare($key);

                $key = $value['key'];

                if (is_object($item)) {
                    // ee(['isObject', gettype($item), $item]);
                    $item = $item->{$key};

                } elseif (is_array($item)) {
                    ee('parse array');
                } else {
                    ee('not array or object');
                }

                $item = $this->matchValue($item, $value['match']);

                continue;

            }

            // ee([78, $item]);

            if (is_object($item) && is_string($key) && isset($item->{$key})) {
                $item = $item->{$key};
            } else {
                // ee([$key, $item]);
                // echo "\n $key, ";
                return '';
            }

            // ee([$key, $item]);
        }

        return $item;
    }

    private function matchValue($arr, $match)
    {
        if (is_numeric($match)) {
            return isset($arr[$match]) ? $arr[$match] : false;
        }

        foreach ($arr as $item) {
            $ok = true;
            foreach ($match as $key => $val) {
                if (!isset($item->{$key}) || $item->{$key} !== $val) {
                    $ok = false;
                    break;
                }
            }

            if ($ok) {
                return $item;
            }
        }
        return false;
    }

    private function parseSquare($str)
    {
        $n = strpos($str, '[');

        $key = substr($str, 0, $n);
        $args = substr($str, $n + 1, -1);

        if (is_numeric($args)) {
            $match = intval($args);
        } else {
            $match = $this->parseKeyValueStr($args);
        }

        return [
            'key' => $key,
            'match' => $match,
        ];

    }

    public function parseKeyValueStr($str)
    {
        $values = [];

        $items = explode('&', $str);

        foreach ($items as $item) {
            $n = strpos($item, '=');
            $key = substr($item, 0, $n);
            $val = substr($item, $n + 1);

            $values[$key] = $val;
        }

        return $values;

    }
}
