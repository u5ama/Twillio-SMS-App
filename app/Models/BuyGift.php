<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuyGift extends Model
{
    protected $guarded = [];

    public function player()
    {
        return $this->hasOne('App\Models\User', 'id','player_id');
    }

    public function gifts()
    {
        return $this->belongsTo('App\Models\Gifts', 'gift_id');
    }

    public function fan()
    {
        return $this->hasOne('App\Models\User', 'id','user_id');
    }
}
