<?php

namespace Masteryl\Template;

class Operations
{
    public static function findItem($arr, $value, $key = 'id')
    {

        if (!is_array($arr)) {
            if ($arr->{$key} === $value) {
                return $arr;
            }

            if (!empty($arr->children)) {
                return self::findItem($arr->children, $value, $key);
            }

            return false;
        }

        foreach ($arr as $item) {
            if ($item->{$key} === $value) {
                return $item;
            }

            if (!empty($item->children)) {
                $result = self::findItem($item->children, $value, $key);
                if ($result) {
                    return false;
                }
            }
        }

        return false;
    }
}
