<?php
/**
 * User: 张世路
 * Date: 2016/9/17
 * Time: 21:56
 */

namespace app\admin\controllers;

use yii\web\Controller;
use app\models\User;
use Yii;

class UserController extends Controller{

    public $layout = 'admin_layout';

    /* 添加新会员 */
    public function actionAdd(){

        $user = new User();

        if(Yii::$app->request->isPost){

            $post = Yii::$app->request->post();

            if($user -> addUser($post)){

                Yii::$app->session->setFlash('info','会员添加成功!');
            }

        }

        $user ->username = '';
        $user ->useremail = '';
        $user ->userpass = '';
        $user ->repass = '';
        return $this->render('add',compact('user'));

    }


}