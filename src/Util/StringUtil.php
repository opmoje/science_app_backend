<?php

namespace App\Util;

final class StringUtil
{
    public static function getLength(string $str)
    {
        $str = trim(strip_tags($str));
        return mb_strlen($str, 'UTF-8');
    }
}
