<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use Translatable;

    public $translatedAttributes = ['name', 'tax_name'];

    protected $guarded = [];
}
