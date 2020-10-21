<?php

namespace Smbear\MessageManage\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Smbear\MessageManage\Channels\WechatsChannel;

class WechatsNotification extends Notification
{
    use Queueable;

    public $params;

    public $connection;

    public $queue;

    public $timeout;

    public $tries;

    public $sleep;

    public function __construct(array $params)
    {
        $this->params = $params;

        $this->queue = config('message.wechat.queue');

        $this->connection = config('message.wechat.connection');

        $this->timeout = config('message.wechat.timeout');

        $this->tries = config('message.wechat.tries');

        $this->sleep = config('message.wechat.sleep');
    }

    public function via($notifiable)
    {
        return [WechatsChannel::class];
    }

    public function toWechat($notifiable)
    {
        if(!empty($notifiable->openid) && $notifiable->subscribe ==1){
            $data = [
                'touser'     =>$notifiable->openid,
                'template_id'=>$this->params['template_id'],
            ];

            if(custom_array_key($this->params,'miniprogram')){
                if(custom_array_key($this->params['miniprogram'],'appid,pagepath')){
                    $data['miniprogram']=[
                        'appid'    => $this->params['miniprogram']['appid'],
                        'pagepath' => $this->params['miniprogram']['pagepath']
                    ];
                }else if(custom_array_key($this->params,'url')){
                    $data['url']=$this->params['url'];
                }
            }

            $data['data'] = custom_array_wechat($this->params['data'],'first','keyword','remark');

            try{
                $this->sendWechat($data);

                return [
                    'errcode' => 0,
                    'errmsg'  => 'success',
                    'data'    => $data
                ];

            }catch (\Exception $exception){
                return [
                    'errcode' => 400,
                    'errmsg'  => $exception->getMessage(),
                    'data'    => $data
                ];
            }
        }
    }

    /**
     * @describe
     * 发送微信公众模板消息
     * @param array $data
     * @return mixed
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 15:47
     */
    public function sendWechat(array $data)
    {
        $app = app('wechat.official_account');

        $app->template_message->send($data);
    }
}