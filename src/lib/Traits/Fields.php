<?php

namespace Masteryl\Traits;

/**
 * Used by model and migration
 */

trait Fields
{
    /**
     *  required props
     *    fields = []
     * seperatior: ':'
     *
     * Default type is string, can be set or left empty
     *
     *
     * "boolean" or "bool"
    "integer" or "int"
    "float" or "double"
    "string"
    "array"
    "object"
    "null"
     */
    // parsed fields

    private $_fields = [];

    private $_bool_fields;

    private $_int_fields;

    private $_float_fields;

    private $_string_fields;

    private $_object_fields;

    private $_array_fields;

    private $_field_types = [
        'bool',
        'int',
        'float',
        'string',
        'object',
        'array',
    ];

    private $_field_empty_values = [
        'bool' => false,
        'int' => 0,
        'float' => 0,
        'string' => '',
        'object' => null,
        'array' => [],
    ];

    // Helper Function

    public function getFieldType($key, $na = false)
    {
        foreach ($this->_field_types as $i) {
            $prop = '_' . $i . '_fields';
            if ($this->{$prop} && in_array($key, $this->{$prop})) {
                return $i;
            }
        }
        return $na;
    }

    // Helper Function

    public function getEmptyValue($key)
    {
        $type = $this->getFieldType($key);

        if (!$type) {
            return false;
        }

        // ee(['getEmtpyVal', $key, $type, $this->_field_empty_values[$type]]);

        return $this->_field_empty_values[$type];

    }

    public function getFieldsString()
    {
        return json_encode($this->getFields());
    }

    public function isField($key)
    {
        return in_array($key, $this->_fields);
    }

    public function getFields($onlyKeys = null, $type = 'array')
    {
        $value = [];

        foreach ($this->_fields as $key) {
            if (isset($this->{$key})) {

                if ($onlyKeys && !in_array($key, $onlyKeys)) {
                    continue;
                }

                $value[$key] = $this->{$key};
            }
        }

        if ($type !== 'array') {
            settype($value, $type);
        }

        return $value;
    }

    /**
     *  takes object, array, or json string
     */

    public function loadFields($value, $force = false)
    {
        if (is_string($value)) {
            $value = json_decode($value);
        } elseif (is_object($value)) {
            $value = (array) $value;
        }

        foreach ($value as $key => $val) {

            // validate
            if (!in_array($key, $this->_fields) && !$force) {
                continue;
            }

            foreach ($this->_field_types as $type) {
                $k = '_' . $type . '_fields';

                if ($this->{$k} && in_array($key, $this->{$k})) {

                    if (empty($val)) {
                        $val = $this->_field_empty_values[$type];
                        break;
                    }
                    if ($type == 'object' && !is_object($val)) {
                        $val = json_decode($val);
                        break;
                    }
                    if ($type == 'array' && !is_array($val)) {
                        $val = json_decode($val, true);
                        // ee('valueSet', $val);
                        break;
                    }
                    settype($val, $type);
                    // // echo "\n set field: {$type} ";
                    if ($type === 'array') {
                        // ee('array', [gettype($val), $type, $key, $val]);
                    }
                    // break;
                }
            }

            // set
            $this->{$key} = $val;
        }
    }

    /**
     * Add during construct
     */

    private function setupFields($fields = null)
    {
        if (!$fields) {
            $fields = $this->fields;
        }

        foreach ($fields as $i) {

            $n = strpos($i, ':');

            // no type
            if ($n === false) {

                // default is string
                if (!$this->_string_fields) {
                    $this->_string_fields = [];
                }
                $this->_string_fields[] = $i;

                $this->_fields[] = $i;
                continue;
            }

            $key = substr($i, 0, $n);

            $this->_fields[] = $key;
            $type = '_' . substr($i, $n + 1) . '_fields';

            // ee($type);

            if (!isset($this->{$type})) {
                $this->{$type} = [];
            }
            $this->{$type}[] = $key;
        }

    }
}
