<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 16:10
 */

namespace app\controllers;

use yii\web\Controller;

class MemberController extends Controller{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 注册登入页 */
    public function actionAuth(){

        $this->getView()->title='会员管理页';
        return $this->render('auth');

    }

}