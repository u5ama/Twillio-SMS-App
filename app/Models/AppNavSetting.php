<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AppNavSetting extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $table = 'app_nav_settings';
}
