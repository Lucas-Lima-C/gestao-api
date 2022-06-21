<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'id', 'photo'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function getPhotoAttribute()
    {
        return $this->attributes['photo'] ? env('APP_URL') . '/user/image/' . $this->id : null;
    }

    public function getPhotoRawAttribute()
    {
        return 'user/' . $this->id . '/perfil.png';
    }
}