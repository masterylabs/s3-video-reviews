<?php

namespace Masteryl\Helpers;

class Obj
{
    public static function maybeToArray($obj)
    {
        if (is_array($obj)) {
            return $obj;
        }

        return self::toArray($obj);
    }

    public static function toArray($obj)
    {
        $arr = [];

        foreach ($obj as $key => $val) {
            $arr[$key] = $val;
        }

        return $arr;
    }
}
