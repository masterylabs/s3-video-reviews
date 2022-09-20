<?php

namespace Masteryl\Helpers;

class Url
{
    public static function append($url, $args = [], $validArgs = null)
    {
        if (empty($args)) {
            return $url;
        }

        if (strstr($url, '?') == false) {
            $url .= '?';
        } else {
            $url = rtrim($url, '&') . '&';
        }

        foreach ($args as $key => $val) {

            if (is_bool($val)) {
                $val = empty($val) ? 0 : 1;
            }

            if ($validArgs && !in_array($key, $validArgs) || $val === '') {
                continue;
            }

            $url .= $key . '=' . urlencode($val) . '&';
        }

        return rtrim($url, '&');
    }
}
