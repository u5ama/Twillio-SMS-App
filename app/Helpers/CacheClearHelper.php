<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;


class CacheClearHelper
{
    public static function languageCacheClear()
    {
        if(Cache::has('languages')){
            Cache::forget('languages');
        }
    }
}
