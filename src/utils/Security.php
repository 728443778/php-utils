<?php

namespace sevenUtils\utils;

use sevenUtils\traits\SingleInstance;

class Security
{
    use SingleInstance;

    public function getRandString(int $length)
    {
        if(function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        return false;
    }
}