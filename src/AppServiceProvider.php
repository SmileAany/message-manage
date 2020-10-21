<?php

namespace Smbear\MessageManage;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function register()
    {
        //单例绑定
        $this->app->singleton('message.manage', function () {
            return new MessageManage();
        });

        //合并配置文件
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'message');
    }

    public function provides()
    {
        return ['message.manage'];
    }

    public function boot()
    {
        //配置文件
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('message.php'),
        ]);

        //数据库
        $this->publishes([
            __DIR__.'/../migrations/'       => database_path('migrations')
        ],'migrations');
    }
}