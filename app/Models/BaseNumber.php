<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseNumber extends Model
{
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'base_numbers';
}
