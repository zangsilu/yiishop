<?php

Yii::setAlias('@tests', dirname(__DIR__) . '/tests/codeception');

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'aliases'=>[
        '@zangsilu/mailerqueue'=>'@vendor/zangsilu/mailerqueue/src' //设置别名,指向vendor下的特定包
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        /**
         * RBAC
         */
        'authManager' => [
            'class' => 'yii\rbac\DbManager',//要使用的管理类
            'itemTable' => '{{%auth_item}}',//(这样写可以指定要使用的表,其他3个也一样,表前缀是在db.php文件配置的)
        ],
        /* 邮件发送设置 */
        'mailer'       => [
            'class'            => 'zangsilu\mailerqueue\MailerQueue',
            'redisDB'=>1,//使用redis1号库存储邮件队列
            'useFileTransport' => false, //必须改为false,true只是生成邮件在runtime文件夹下，不发邮件
            'transport'        => [
                'class'      => 'Swift_SmtpTransport',
                'host'       => 'smtp.163.com',
                'username'   => 'zangsilu@163.com',
                'password'   => 'zsl13586722',
                'port'       => '465',//端口25对应tls协议 端口465对应ssl协议
                'encryption' => 'ssl',
            ],
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'redis' => [
            'class' => 'yii\redis\Connection',
//            'hostname' => '192.168.2.200',
            'hostname' => '127.0.0.1',
            'port' => 6379,
            'database' => 0,
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
        'db' => $db,
    ],
    'params' => $params,
    /*
    'controllerMap' => [
        'fixture' => [ // Fixture generation command line.
            'class' => 'yii\faker\FixtureController',
        ],
    ],
    */
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
