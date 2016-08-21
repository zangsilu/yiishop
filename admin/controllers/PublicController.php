<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 21:05
 */
namespace app\admin\controllers;

use yii\web\Controller;

class PublicController extends Controller{

    //禁用布局
    public $layout = false;

    /* 后台管理员登入 */
    public function actionLogin(){

    return $this->render('login');

    }


}