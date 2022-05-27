<?php

namespace App\Helpers;

use Exception;
use phpseclib\Crypt\RSA as Crypt_RSA;

class ConvertV2Helper
{
    public static function toJson($value, callable $formatter = null)
    {
        try {
            if (is_callable($formatter)) {
                $value = $formatter($value);
            }
            if (is_string($value)) {
                return $value;
            }
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        } catch (Exception $e) {
            LoggingHelper::logException($e);
        }
        return null;
    }

    public static function encryptRSA($data, $publicKey)
    {
        //https://stackoverflow.com/questions/59102289/laravel-encrypt-the-aes-key-with-rsa-public-key
        //initialise Algorithm
        $rsa = new Crypt_RSA();
        $rsa->loadKey($publicKey); // public key
        $rsa->setEncryptionMode(2);
        return base64_encode($rsa->encrypt($data));
    }
}
