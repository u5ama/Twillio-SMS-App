<?php

namespace App\Models;

use App\Http\Resources\GuestUserResource;
use App\Http\Resources\UserResource;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasRoles;

    protected $guarded = [];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Passenger (User Profile) Table Relation
    public function category()
    {
        return $this->hasOne('App\Models\Categories', 'id','category_id');
    }

    // User Resource Table Relation
    public static function getuser($id){

        $user = UserResource::collection(User::where('id',$id)->get());
        return $user[0];
    }


}
