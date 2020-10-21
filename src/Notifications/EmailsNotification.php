<?php

namespace Smbear\MessageManage\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
use Smbear\MessageManage\Channels\EmailsChannel;
use App\Mail\UserMail;

class EmailsNotification extends Notification implements ShouldQueue
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

        $this->queue = config('message.email.queue');

        $this->connection = config('message.email.connection');

        $this->timeout = config('message.email.timeout');

        $this->tries = config('message.email.tries');

        $this->sleep = config('message.email.sleep');
    }

    public function via($notifiable)
    {
        return [EmailsChannel::class];
    }

    public function toEmail($notifiable)
    {
        if(!empty($notifiable->email)){

            $data = (new UserMail($this->params))->render();

            try{

                Mail::to($notifiable->email)->send(new UserMail($this->params));
                
                return [
                    'errcode'=>0,
                    'errmsg' =>'success',
                    'data'   =>$data
                ];

            }catch (\Exception $exception){
                return [
                    'errcode' => 400,
                    'errmsg'  => $exception->getMessage(),
                    'data'   =>$data
                ];
            }
        }
    }
}