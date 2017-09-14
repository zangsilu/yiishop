<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 1:39
 */

namespace app\controllers;

use app\models\Users;

class IndexController extends CommonController{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 前台首页 */
    public function actionIndex(){
        return $this->render('index');
    }

    public function actionError()
    {
        echo '404';
    }

}