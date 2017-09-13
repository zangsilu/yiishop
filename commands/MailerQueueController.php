<?php

namespace app\commands;


use Yii;
use yii\console\Controller;

class MailerQueueController extends Controller
{

    /**
     * 发送redis队列中的邮件
     * php yii mailer-queue/send
     */
    public function actionSend()
    {
        $mailer = Yii::$app->mailer;
        $mailer->process();
        echo '发送完毕!';
    }

}