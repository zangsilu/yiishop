<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 1:39
 */

namespace app\controllers;

use app\models\Users;
use yii\web\Controller;

class IndexController extends Controller{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 前台首页 */
    public function actionIndex(){


        return $this->render('index',compact('data'));

    }

}