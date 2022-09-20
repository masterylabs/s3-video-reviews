<?php

namespace Masteryl\Traits;

trait UrlAppend
{
    public static function urlAppend($url, $params = [])
    {
        $url .= strpos($url, '?') > -1 ? '&' : '?';

        foreach ($params as $key => $val) {
            $val = urlencode($val);
            $url .= "{$key}={$val}&";
        }
        return rtrim($url, '&');
    }
}
