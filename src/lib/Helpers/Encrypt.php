<?php

namespace Masteryl\Helpers;

use Masteryl\Helpers\Encode;

class Encrypt
{
    public static function bundle($data, $key = 'secret')
    {
        $data = Encode::toString($data);

        $data = base64_encode($data);

        if (!self::canEncrypt()) {
            return $data;
        }

        $method = self::getEncryptionMethod();

        $iv = substr(hash('sha256', $key), 0, 16);

        return base64_encode(openssl_encrypt($data, $method, $key, 0, $iv));
    }

    public static function open($data, $key = 'secret')
    {
        $data = base64_decode($data);

        if (self::canEncrypt()) {
            $method = self::getEncryptionMethod();

            $iv = substr(hash('sha256', $key), 0, 16);

            $data = openssl_decrypt($data, $method, $key, 0, $iv);
            $data = base64_decode($data);
        }

        return Encode::fromString($data);
    }

    public static function getEncryptionMethod()
    {
        return 'AES-128-CBC';
    }

    public static function canEncrypt()
    {
        return function_exists('openssl_encrypt') && function_exists('openssl_decrypt') && function_exists('hash');
    }

}
