<?php

namespace Smbear\MessageManage\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Models\Wechats;

class WechatsChannel
{
    public function send($notifiable, Notification $notification)
    {
        if($notifiable instanceof AnonymousNotifiable){
            $class = new \stdClass();
            $class->user_id = null;
            $class->openid  = $notifiable->routes[__CLASS__];
            $class->subscribe = 1;
            $notifiable = $class;
        }

        $res = $notification->toWechat($notifiable);

        $data = [
            'user_id'=>$notifiable->user_id,
            'openid' =>$notifiable->openid,
            'data'   =>json_encode($res['data']),
            'msg'    =>$res['errmsg']
        ];

        if($res['errcode'] == 0){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }

        Wechats::create($data);
    }
}