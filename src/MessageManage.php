<?php

namespace Smbear\MessageManage;

use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Collection;
use Smbear\MessageManage\Channels\EmailsChannel;
use Smbear\MessageManage\Notifications\EmailsNotification;
use Smbear\MessageManage\Channels\WechatsChannel;
use Smbear\MessageManage\Notifications\WechatsNotification;
use Smbear\MessageManage\Traits\ApiResponse;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserMail;
use App\Models\Mation;
use App\Models\Emails;
use App\Models\Wechats;

class MessageManage
{
    use ApiResponse;

    /**
     * @describe
     * 发送邮件
     * @param array $params
     * @param $users
     * @return mixed
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 15:01
     */
    public function sendEmails(array $params,$users)
    {
        if(!empty($users) && !empty($params) && custom_array_key($params,'type',TRUE)){

            if(is_object($users) && ($users instanceof Users || $users instanceof Collection)){

                Notification::send($users,new EmailsNotification($params));
            }

            if(is_string($users) && $email = $users){

                Notification::route(EmailsChannel::class, $email)->notify(new EmailsNotification($params));
            }

            if(is_array($users) && $emails = $users){

                foreach($emails as $value){
                    Notification::route(EmailsChannel::class, $value)->notify(new EmailsNotification($params));
                }
            }
        }

        return $this->failed('数据格式错误');
    }

    /**
     * @describe
     * 邮件重新发送
     * @param int $id
     * @return mixed
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 14:45
     */
    public function againEmail(int $id)
    {
        $res = Emails::find($id);

        if($res){

            $email = $res->email;
            $params = $res->params;

            if($params){
                $params = json_decode($params,true);
            }
            
            try{
                Mail::to($email)->send(new UserMail($params));

                $res->msg = 'success';
                $res->status = 1;

                $res->save();
            }catch (\Exception $exception){
                $res->msg = $exception->getMessage();
                $res->status = 0;

                $res->save();
            }
        }

        return $this->failed('邮件id不存在');
    }

    /**
     * @describe
     * 发送微信模板消息
     * @param array $params
     * @param $users
     * @return mixed
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 16:33
     */
    public function sendWechats(array $params,$users)
    {
        if(!empty($users) && !empty($params) && custom_array_key($params,'template_id,data',true)){

            if(is_object($users) && ($users instanceof Mation || $users instanceof Collection)){

                Notification::send($users,new WechatsNotification($params));

            }

            if(is_string($users) && $openid = $users){

                Notification::route(WechatsChannel::class, $openid)->notify(new WechatsNotification($params));
            }

            if(is_array($users) && $openids = $users){

                foreach($openids as $value){
                    Notification::route(WechatsChannel::class, $value)->notify(new WechatsNotification($params));
                }
            }
        }

        return $this->failed('数据格式错误');
    }

    /**
     * @describe
     * 重新发布微信模板消息
     * @param int $id
     * @return mixed
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-10-21 17:46
     */
    public function againWechat(int $id)
    {
        $res = Wechats::find($id);

        if($res){
            $data = $res->data;

            if($data){
                $data = json_decode($data,true);
            }

            try{

                $app = app('wechat.official_account');
                $app->template_message->send($data);

                $res->msg = 'success';
                $res->status = 1;

                $res->save();
            }catch (\Exception $exception){
                $res->msg = $exception->getMessage();
                $res->status = 0;

                $res->save();
            }
        }

        return $this->failed('模板消息id不存在');
    }
}