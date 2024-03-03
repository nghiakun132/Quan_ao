<?php

use Illuminate\Support\Facades\Cache;

const TIME_CACHE = 600;

if (!function_exists('cacheData')) {
    function cacheData($key, $value)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        Cache::put($key, $value, TIME_CACHE);

        return $value;
    }
}


