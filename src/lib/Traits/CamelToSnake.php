<?php

namespace Masteryl\Traits;

trait CamelToSnake
{
    public static function camelToSnake($str, $sep = '_')
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', $sep . '$0', $str));
    }
}
