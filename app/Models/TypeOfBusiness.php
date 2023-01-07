<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class TypeOfBusiness extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $table = 'type_of_businesses';
}
