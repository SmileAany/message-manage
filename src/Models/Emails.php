<?php

namespace Smbear\MessageManage\Models;

use Illuminate\Database\Eloquent\Model;

class Emails extends Model
{
    protected $table = 'emails';

    protected $fillable = [
        'user_id','email','type','params','data','msg','status'
    ];
}