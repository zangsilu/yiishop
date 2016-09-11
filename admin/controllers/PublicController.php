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
use Yii;

class PublicController extends Controller{

    //禁用布局
    public $layout = false;

    /* 后台管理员登入 */
    public function actionLogin(){

        //如果用户已经登入,直接跳转到后台首页
        if(Yii::$app->session->has('admin')){
            $this->redirect(['default/index']);
        }

        //实例化模型,用于创建表单做字段映射;
        $admin = new Admin();
        $resquest = Yii::$app->request;

        //判断是否登入提交
        if($resquest ->isPost){
           $data = $resquest->post();
            //验证提交数据,如果成功跳转到后台首页
            if($admin->login($data)){
                $this->redirect(['default/index']);
                Yii::$app->end();
            }
        }
        return $this->render('login',compact('admin'));
    }

    /* 管理员退出 */
    public function actionLogout(){

        $session = Yii::$app->session;
        $session->remove('admin');

        if(!isset($session['admin']['isLogin'])){
            $this->redirect(['public/login']);
        }

    }

    /* 找回密码 */
    public function actionSeekpass(){

        //实例化一个模型
        $admin = new Admin();

        if(Yii::$app->request->isPost){

            $post = Yii::$app->request->post();

            //判断是否发送成功
            if($admin -> seekpass($post)){
                return true;
            }
        }

        return $this->render('seekpass',compact('admin'));
    }

}