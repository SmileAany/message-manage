<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWechatsTable extends Migration
{
    /**
     * @describe
     * 微信模板消息记录表
     * @auth smile
     * @email ywjmylove@163.com
     * @date 2020-8-26 10:17
     */
    public function up()
    {
        Schema::create('wechats', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->comment('用户id');
            $table->string('openid',100)->nullable(false)->comment('用户的openid');
            $table->text('params')->nullable(false)->comment('数据参数');
            $table->text('data')->nullable(false)->comment('数据');
            $table->text('msg')->nullable(false)->comment('错误提示 成功返回success');
            $table->tinyInteger('status')->nullable(false)->default(1)->comment('模板消息状态 0：失败 1：成功');
            $table->timestamp('created_at')->nullable()->comment('发送时间');
            $table->timestamp('updated_at')->nullable()->comment('更改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wechats');
    }
}
