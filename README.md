### 介绍
安装包基于Laravel8.0开发，目前只支持Laravel框架的消息推送，整体采用频道加通知的方式进行推送，完美兼容于队列推送，后期可采用supervisor进行队列守护
### 安装配置
``` php artisan vendor:publish --provider="Smbear\MessageManage\AppServiceProvider" ```
- 迁移数据

​``` php artisan migrate ```
### 使用教程
- 门面使用
    - 发送邮件
    ```
        use MessageManage; 
    
    ```