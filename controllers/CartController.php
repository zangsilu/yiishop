<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:46
 */
namespace app\controllers;


class CartController extends CommonController{

    //指定页面使用的布局文件
    public $layout = 'layout2';

    /* 购物车页 */
    public function actionCart(){

        return $this->render('cart');

    }


}