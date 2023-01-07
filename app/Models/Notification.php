<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use Translatable;

    public $translatedAttributes = ['title','message','description'];

    protected $guarded = [];

}
