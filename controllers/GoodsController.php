<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 15:03
 */
namespace app\controllers;

use yii\web\Controller;

class GoodsController extends Controller{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 商品列表页 */
    public function actionList(){

        return $this->render('list');

    }

    /* 商品详情页 */
    public function actionDetails(){

        return $this->render('details');

    }

}