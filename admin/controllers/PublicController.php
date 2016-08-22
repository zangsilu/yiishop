<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 21:05
 */
namespace app\admin\controllers;

use app\admin\models\Admin;
use yii\web\Controller;

class PublicController extends Controller{

    //禁用布局
    public $layout = false;

    /* 后台管理员登入 */
    public function actionLogin(){

    //实例化模型,用于创建表单做字段映射;
    $admin = new Admin();

    return $this->render('login',compact('admin'));

    }


}