<?php

$params = require(__DIR__ . '/params.php');
$adminmenu = require(__DIR__ . '/adminmenu.php');

$config = [
    'id'           => 'basic',
    'language'     => 'zh-CN',
    'charset'      => 'utf-8',
    'defaultRoute' => 'index',//修改默认控制器为前台index控制器
    'basePath'     => dirname(__DIR__),//项目根目录
    'timeZone'     => 'Asia/Chongqing',//设置当前时区为北京时间
    'bootstrap'    => ['log'],
    //设置别名,指向vendor下的特定包(第三方无法使用composer加载的包)
    /*'aliases'=>[
        '@zangsilu/mailerqueue'=>'@vendor/zangsilu/mailerqueue/src'
    ],*/
    'components'   => [
        'request'       => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey'  => 'pdNrTOsrTVlnSGcRBU-kQc75sSpRVjJq',
            // Enable Yii Validate CSRF Token
            'enableCsrfValidation' => true,
        ],
        /**
         * 使用redis服务器存储session,解决负载均衡各服务器session不统一问题
         */
        'session' => [
              'class' => 'yii\redis\Session',
              'redis' => [
                  'hostname' => '127.0.0.1',
                  'port' => 6379,
                  'database' => 3,
              ],
            'keyPrefix'=>'yii_shop_sess'
          ],
        'cache'         => [
//            'class' => 'yii\caching\FileCache',
            'class' => 'yii\redis\Cache',
            'redis' => [
                'hostname' => '127.0.0.1',
                'port'     => 6379,
                'database' => '2',
            ],
        ],
        /**
         * RBAC
         */
        'authManager'   => [
            'class'        => 'yii\rbac\DbManager',
            //要使用的管理类
            'itemTable'    => '{{%auth_item}}',
            //(这样写可以指定要使用的表,其他3个也一样,表前缀是在db.php文件配置的)
            'defaultRoles' => ['default'],
            //当登入用户没有任何角色时,自动拥有该角色
        ],
        /**
         * 前台用户组件
         */
        'user'          => [
            'identityClass'   => 'app\models\User',
            'identityCookie'  => [
                'name'     => '_user_identity',
                'httpOnly' => true,
            ],
            'idParam'         => '__user_id',
            'enableAutoLogin' => true,
            'loginUrl'        => ['/member/auth'],//默认登入页
        ],
        /**
         * 后台用户组件
         */
        'admin'         => [
            'class'           => 'yii\web\user',
            'identityClass'   => 'app\admin\models\admin',
            'identityCookie'  => [
                'name'     => '_admin_identity',
                'httpOnly' => true,
            ],
            'idParam'         => '__admin_id',
            'enableAutoLogin' => true,
            'loginUrl'        => ['admin/public/login'],//后台默认登入页
        ],
        'errorHandler'  => [
            'errorAction' => 'index/error',
        ],
        'redis'         => [
            'class'    => 'yii\redis\Connection',
//            'hostname' => '192.168.2.200',
            'hostname' => '127.0.0.1',
            'port'     => 6379,
            'database' => 0,
        ],
        /* 邮件发送设置 */
        'mailer'        => [
            'class'            => 'zangsilu\mailerqueue\MailerQueue',
            'redisDB'          => 1,//使用redis1号库存储邮件队列
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
        'sentry' => [
            'class' => 'mito\sentry\Component',
            'dsn' => 'https://905d60a0073a4851855cc7ecefd3d778:d6b3a82903b641d18c07d9902f713bb8@sentry.io/216254', // private DSN
            'publicDsn' => 'https://905d60a0073a4851855cc7ecefd3d778@sentry.io/216254',
            'environment' => 'staging', // if not set, the default is `production`
            'jsNotifier' => true, // to collect JS errors. Default value is `false`
            'jsOptions' => [ // raven-js config parameter
                'whitelistUrls' => [ // collect JS errors from these urls
                    'http://staging.my-product.com',
                    'https://my-product.com',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'mito\sentry\Target',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'logFile' => '@app/runtime/logs/shop/application.log',
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['info', 'trace'],
                    'logFile' => '@app/runtime/logs/shop/info.log',
                    'categories' => ['myinfo'],
                    'logVars' => [],
                ],
                /*[
                 'class' => 'yii\log\EmailTarget',
                 'mailer' =>'mailer',
                 'levels' => ['error', 'warning'],
                 'message' => [
                     'from' => ['zangsilu@163.com'],
                     'to' => ['532817108@qq.com'],
                     'subject' => 'yii_shop的日志',
                 ],
                ],*/
            ],
        ],
        'db'            => require(__DIR__ . '/db.php'),
        'urlManager'    => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'suffix'  => '.do',
//            'suffix' => '.html',goods/details.do?goods_id=28
            'rules'           => [
                '<controller:(index|cart|order)>' => '<controller>/index',
                '<controller:(goods)>' => '<controller>/list',
                'goods-cid-<cid:\d+>' => 'goods/list',
                'goods-<goods_id:\d+>' => 'goods/details',
                [
                    'pattern' => 'admin',
                    'route' => '/admin/default/index',
                    'suffix' => '.xx',
                ],
            ],
        ],
        'elasticsearch' => [
            'class' => 'yii\elasticsearch\Connection',
            'nodes' => [
                ['http_address' => '127.0.0.1:9200'],
                // configure more hosts if you have a cluster
            ],
        ],
    ],
    'params'       => \yii\helpers\ArrayHelper::merge($params,
        ['adminmenu' => $adminmenu]),
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
