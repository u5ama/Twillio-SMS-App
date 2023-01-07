<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GiftsNotifications extends Model
{
    protected $table = 'gifts_notifications';
    protected $guarded = [];

    public function sender()
    {
        return $this->hasOne('App\Models\User', 'id','sender_id');
    }

    public function gift()
    {
        return $this->belongsTo('App\Models\Gifts', 'gift_id');
    }
}
