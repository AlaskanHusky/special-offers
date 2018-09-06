<?php

class RandomGenerator
{
    public static function hexString($length = 13)
    {
        if (function_exists('random_bytes')) {
            try {
                $bytes = random_bytes(ceil($length / 2));
            } catch (\Exception $e) {
                echo $e->getMessage(), '\n';
            }
        } elseif (function_exists('openssl_random_pseudo_bytes')) {
            $bytes = openssl_random_pseudo_bytes(ceil($length / 2));
        } else {
            throw new \Exception("Not available cryptographically secure random function.");
        }
        return substr(bin2hex($bytes), 0, $length);
    }
}