<?php

namespace Masteryl\Helpers;

class Fields
{
    /**
     * Value and type
     */

    public static function getKeys($optionFields)
    {
        $fields = [];

        foreach ($optionFields as $key => $val) {

            if (is_int($key)) {
                $val = [$val];
            }

            if (is_array($val)) {
                $fields = array_merge($fields, self::parse($val));
            }

        }

        return $fields;
    }

    public static function parse($fields)
    {
        return array_map(function ($field) {
            $value = $field['value'];
            if (!empty($field['type'])) {
                $value .= ':' . $field['type'];
            }
            return $value;
        }, $fields);
    }
}
