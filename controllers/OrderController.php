<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:59
 */
namespace app\controllers;

use yii\web\Controller;

class OrderController extends Controller{


    /* 订单结算页 */
    public function actionCheckout(){

        //指定页面使用的布局文件
        $this->layout = 'layout2';

        return $this->render('checkout');

    }

    /* 订单列表页 */
    public function actionOrderlist(){

        //指定页面使用的布局文件
        $this->layout = 'layout1';

       return $this->render('orderlist');

    }

}