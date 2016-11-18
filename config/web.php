<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'defaultRoute' => 'index',//修改默认控制器为前台index控制器
    'basePath' => dirname(__DIR__),//项目根目录
    'timeZone'=>'Asia/Chongqing',//设置当前时区为北京时间
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'pdNrTOsrTVlnSGcRBU-kQc75sSpRVjJq',
                // Enable Yii Validate CSRF Token
                'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /* 邮件发送设置 */
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false, //必须改为false,true只是生成邮件在runtime文件夹下，不发邮件
            'transport' => [
              'class' => 'Swift_SmtpTransport',
              'host' => 'smtp.163.com',
              'username' => 'zangsilu@163.com',
              'password' => '',
              'port' => '465',//端口25对应tls协议 端口465对应ssl协议
              'encryption' => 'ssl',
          ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix' => '.html',
            'rules' => [
                // ...
            ],
        ],
    ],
    'language' => 'zh-CN',
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
//        'allowedIPs' => ['192.168.2.101'],
    ];

    //开启新创建的后台(admin)模块
    $config['modules']['admin'] = [
        'class' => 'app\admin\admin',
    ];
}

return $config;
