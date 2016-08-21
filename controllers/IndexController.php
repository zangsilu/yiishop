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

    public function actionIndex(){

        $data = '我是index控制器/index方法';

        return $this->render('index',compact('data'));

    }

    public function actionUser(){

      $data = Users::find()->one();

       return $this->render('index',compact('data'));

    }

}