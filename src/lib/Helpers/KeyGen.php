<?php

namespace Masteryl\Helpers;

class KeyGen
{
    public static function password($len = 10)
    {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = [];
        $alphaLength = strlen($alphabet) - 1;
        for ($i = 0; $i < $len; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass);
    }

    public static function publicKey($len = 32)
    {
        return self::make($len, 'pk_');
    }

    public static function secretKey($len = 32)
    {
        return self::make($len, 'sk_');
    }

    public static function make($len = 32, $prefix = '')
    {
        if (!strlen($prefix) % 2 == 0) {
            $prefix .= rand(0, 9); // buffer
        }

        if ($prefix != '') {
            $len = $len - strlen($prefix);
        }

        return $prefix . bin2hex(random_bytes($len / 2));
    }
}
