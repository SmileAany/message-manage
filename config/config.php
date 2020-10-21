<?php

return [
    'email'=>[
        'queue'      => 'email_queue',
        'timeout'    => 60,
        'connection' => 'redis',
        'tries'      => 3,
        'sleep'      => 5
    ],

    'wechat'=>[
        'queue'      => 'wechat_queue',
        'timeout'    => 60,
        'connection' => 'redis',
        'tries'      => 3,
        'sleep'      => 5
    ]
];