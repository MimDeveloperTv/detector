<?php

namespace App\Foundation\Utils;

class Utils
{
    /**
     * Get user id from http request header sent by other services
     *
     * @return array|string|null
     */
    public static function getUserId(): array|string|null
    {
        return request()->header('X-User-Id');
    }
}
