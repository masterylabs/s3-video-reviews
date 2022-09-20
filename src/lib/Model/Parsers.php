<?php
namespace Masteryl\Model;

use Masteryl\Helpers\Encode;

trait Parsers
{
    /**
     * From database
     */

    protected function unparseItem($item, $removeHidden = false)
    {
        if (is_array($item)) {
            $item = (object) $item;
        }
        // ee('unparseItem', $item);
        foreach ($item as $key => $val) {

            if ($removeHidden && $this->_hidden && in_array($key, $this->_hidden)) {
                unset($item->{$key});
                continue;
            }

            $item->{$key} = $this->unparseCol($key, $val);
        }
        return $item;
    }

    public function unparseCol($key, $val)
    {

        if (is_null($val)) {
            // echo "\n null value {$val} ";
            if ($this->default_values && isset($this->default_values[$val])) {
                return $this->default_values[$val];
            }
            return null;
        }

        // default with empty value

        if (is_string($val) && $val === '' && $this->default_values && isset($this->default_values[$val])) {
            return $this->default_values[$val];
        }
        //

        if (strpos($key, 'is_') === 0 || ($this->_bool && in_array($key, $this->_bool))) {
            return !empty($val) ? true : false;
        }

        //
        if ($this->_int && in_array($key, $this->_int)) {
            // settype($val, 'int');
            return (int) $val;
        }
        //
        elseif ($this->_float && in_array($key, $this->_float)) {
            // settype($val, 'float');
            return (float) $val;
        }
        //
        elseif ($this->_json && in_array($key, $this->_json)) {
            return json_decode($val);
        }
        //
        elseif ($this->_array && in_array($key, $this->_array)) {
            return json_decode($val);
        }
        //
        elseif ($this->_wild && in_array($key, $this->_wild) && is_string($val)) {
            return Encode::fromString($val);
        }

        return $val;
    }

    /**
     * To datbase
     */

    public function parseCol($key, $val)
    {
        if (strpos($key, 'is_') === 0 || ($this->_bool && in_array($key, $this->_bool))) {
            return !empty($val) ? 1 : 0;
        }

        if ($this->_wild && in_array($key, $this->_wild)) {

            return Encode::toString($val);
        }

        if (is_object($val) || is_array($val)) {
            return json_encode($val);
        }

        return $val;
    }

    // during setup

    protected function unparseResults($items)
    {
        if (empty($items)) {
            return [];
        }

        if (is_array($items)) {
            // paginated
            if (isset($items['data'])) {
                $items['data'] = $this->unparseItems($items['data']);
            } else {
                $items = $this->unparseItems($items);
            }
        }

        return $items;
    }

    private function unparseItems($items)
    {
        foreach ($items as $i => $item) {
            $items[$i] = $this->unparseItem($item, true);
        }

        return $items;
    }

    private function parseFills()
    {
        foreach ($this->fills as $i => $key) {
            if (strstr($key, '|') == true) {
                $part = explode('|', $key);
                $key = array_shift($part);
                $this->fills[$i] = $key;
                foreach ($part as $p) {
                    $pk = '_' . $p;

                    if (!$this->{$pk}) {
                        $this->{$pk} = [];
                    }
                    $this->{$pk}[] = $key;
                }

            }
        }

        // ee('fills parsed', $this);
    }
}
