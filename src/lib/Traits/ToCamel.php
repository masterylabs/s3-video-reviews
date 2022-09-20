<?php

namespace Masteryl\Traits;

trait ToCamel
{
    public static function toCamel($str, $capFirst = false, $sep = '_')
    {
        $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $str)));

        if (!$capFirst) {
            $str[0] = strtolower($str[0]);
        }

        return $str;
    }
}
