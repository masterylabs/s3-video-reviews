<?php

namespace Masteryl\Helpers;

class Encode
{
    public static function toArray($obj)
    {
        $arr = [];
        foreach ($obj as $key => $val) {
            $arr[$key] = $val;
        }

        return $arr;
    }

    public static function toBase($value)
    {
        return base64_encode(self::toString($value));
    }

    public static function fromBase($str)
    {
        return self::fromString(base64_decode($str));
    }

    public static function toString($value)
    {
        return json_encode([
            'type' => gettype($value),
            'value' => $value,
            // '_encoder' => 'toString',
        ]);
    }

    public static function fromString($str)
    {
        if (empty($str)) {
            return false;
        }

        $json = json_decode($str);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $str;
        }

        if (!isset($json->type) || !isset($json->value)) {
            return false;
        }

        if ($json->type === 'object') {
            return $json->value;
        }

        if ($json->type === 'array') {
            return json_decode($str, true)['value'];
        }

        settype($json->value, $json->type);

        return $json->value;
    }
}
