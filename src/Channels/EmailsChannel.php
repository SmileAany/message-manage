<?php

namespace Smbear\MessageManage\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use App\Models\Emails;

class EmailsChannel
{
    /**
     * @describe
     * 发送邮件
     * @param $notifiable
     * @param Notification $notification
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 14:23
     */
    public function send($notifiable,Notification $notification)
    {
        if($notifiable instanceof AnonymousNotifiable){
            $class = new \stdClass();
            $class->id = null;
            $class->email  = $notifiable->routes[__CLASS__];
            $notifiable = $class;
        }

        $res = $notification->toEmail($notifiable);

        $type = $notification->params['type'];

        $data = [
            'user_id'=>$notifiable->id,
            'email'  =>$notifiable->email,
            'type'   =>$type,
            'params' =>json_encode($notification->params),
            'data'   =>$res['data'],
            'msg'    =>$res['errmsg'],
        ];

        if($res['errcode'] == 0){
            $data['status'] = 1;
        }else{
            $data['status'] = 0;
        }

        Emails::create($data);

    }
}