<?php

namespace Smbear\MessageManage\Models;

use Illuminate\Database\Eloquent\Model;

class Wechats extends Model
{
    protected $table = 'wechats';

    protected $fillable = [
        'user_id','openid','type','data','msg','status'
    ];
}