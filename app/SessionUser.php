<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SessionUser extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'token','refresh_token','token_expired','token_expired_reset','user_id'
        ];
}
