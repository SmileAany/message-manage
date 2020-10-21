<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->nullable()->comment('用户id');
            $table->string('email',100)->nullable(false)->comment('用户的邮箱');
            $table->tinyInteger('type')->nullable(false)->comment('邮件类型');
            $table->text('params')->nullable(true)->comment('邮件参数');
            $table->text('data')->nullable(false)->comment('数据');
            $table->text('msg')->nullable(false)->comment('错误提示');
            $table->tinyInteger('status')->nullable(false)->default(1)->comment('短信状态 0：失败 1：成功');
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
        Schema::dropIfExists('emails');
    }
}