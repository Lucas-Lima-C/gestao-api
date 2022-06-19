<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRecovery extends Model
{
    protected $table = 'user_recoveries';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'id', 'user_id', 'token', 'expired'
    ];
}