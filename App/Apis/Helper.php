<?php

/**
 * @package SDWPRM
 */

namespace App\Apis;

class Helper
{
    public static function hash ($data)
    {
        return md5 ($data) . crc32($data);
    }
}
