<?php

namespace Smbear\MessageManage\Facades;

use Illuminate\Support\Facades\Facade;

class MessageManage extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'message.manage';
    }
}