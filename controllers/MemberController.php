<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/8/21
 * Time: 16:10
 */

namespace app\controllers;

use app\models\User;
use yii\bootstrap\Carousel;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use Yii;

class MemberController extends CommonController{

    //指定页面使用的布局文件
    public $layout = 'layout1';

    /* 注册登入页 */
    public function actionAuth(){

        //如果已经登入了,直接跳转到首页
        if(Yii::$app->session['isLogin']){
            $this->redirect('/');
        }

        //记录是从哪个页面来的
        if(Yii::$app->request->isGet){
            $referrer = Yii::$app->request->referrer;
            if(empty($referrer)){
                $referrer = '/';
            }
            Yii::$app->session->setFlash('referrer',$referrer);
        }

        //如果是登入请求
        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            $user = new User();
            if($user->userLogin($post)){
                //登入成功,拿到来往页;
                $referrer = Yii::$app->session->getFlash('referrer');
                $this->redirect($referrer);
                Yii::$app->end();
            }

            Yii::$app->session->setFlash('info',array_values($user->getErrors())[0][0]);
        }


        $this->getView()->title='会员管理页';
        return $this->render('auth');

    }

    /* 注册 */
    public function actionRegister(){

        if(Yii::$app->request->isPost){

            $post = Yii::$app->request->post();

            $user = new User();

            if($user ->userRegister($post)){
                Yii::$app->session->setFlash('info','注册邮件发送,请登入邮箱查看!');
                $this->redirect(['member/auth']);
                Yii::$app->end();
            }

            Yii::$app->session->setFlash('info',$user->getErrors('useremail')[0]);
            $this->redirect(['member/auth']);
            Yii::$app->end();
        }

    }

    /* 前台退出登入 */
    public function actionLogout(){

        \Yii::$app->session->remove('username');
        \Yii::$app->session->remove('isLogin');
        if(!isset(\Yii::$app->session['isLogin'])){
            return $this->goBack(Yii::$app->request->referrer);
        }

    }

}