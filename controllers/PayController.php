<?php

/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 16:10
 */


namespace app\controllers;
use app\models\Pay;
use Yii;

class PayController extends CommonController
{
    
    public function behaviors()
    {
        return [
            'accessFilter' => [
                'class'  => AccessControl::className(),
                'only'   => ['*'],//所有方法都受管制
                'except' => [],//除此之外
                'rules'  => [
                    [
                        'allow'   => false,//不允许访问
                        'actions' => ['*'],// * 表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['?'],// ? 表示 guest 未登入的
                    ],
                    [
                        'allow'   => true,//允许访问
                        'actions' => ['*'],//*表示所有,如果要限制单独某些方法,直接写方法名字
                        'roles'   => ['@'],// @ 表示 登入用户
                    ],
                ],
            ],
        ];
    }

    //禁用csrf认证
    public $enableCsrfValidation = false;

    /**
     * 支付宝异步通知回调地址(用于更改订单状态)
     */
    public function actionNotify()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            if (Pay::notify($post)) {
                echo "success";
                exit;
            }
            echo "fail";
            exit;
        }
    }

    /**
     * 支付宝同步通知回调地址(用于显示支付成功页面,只有支付成功后才发生回调)
     * @return string
     */
    public function actionReturn()
    {
        $this->layout = 'layout2';
        $status = Yii::$app->request->get('trade_status');
        if ($status == 'TRADE_SUCCESS') {
            $s = 'ok';
        } else {
            $s = 'no';
        }
        return $this->render("status", ['status' => $s]);
    }
}





