<?php

namespace Masteryl\Helpers;

use Masteryl\Traits\CamelToSnake;
use Masteryl\Traits\ToCamel;

class Str
{
    use CamelToSnake, ToCamel;

    public static function endsWith($haystack, $needle)
    {
        if (function_exists('str_ends_with')) {
            return str_ends_with($haystack, $needle);
        }

        // polyfill
        if ('' === $haystack && '' !== $needle) {
            return false;
        }
        $len = strlen($needle);

        return 0 === substr_compare($haystack, $needle, -$len, $len);

    }

    public static function extension($str, $sep = '.')
    {
        $i = explode($sep, $str);
        return array_pop($i);
    }
}
