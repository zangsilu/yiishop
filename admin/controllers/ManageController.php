<?php
/**
 * Created by PhpStorm.
 * User: MBENBEN
 * Date: 2016/9/4
 * Time: 20:44
 */

namespace app\admin\controllers;

use app\admin\models\Admin;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use Yii;

class ManageController extends BaseController{

    public $layout = 'admin_layout';

    /* 处理找回密码 */
    public function actionMailchangepass(){

        $this->layout = false;
        $admin = new Admin();

        //接收返回来的参数
        $tamp = Yii::$app->request->get('tamp');
        $admin_user = Yii::$app->request->get('admin_user');
        $token = Yii::$app->request->get('token');

        //结合自己的算法生成token与返回回来的token进行比对
        $newToken = $admin ->createToken($tamp,$admin_user);
        if($newToken != $token){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        //限定验证连接有效期为5分钟
        if(time() - $tamp >3000){
            $this->redirect(['public/login']);
            Yii::$app->end();
        }

        //处理重置密码
        if (Yii::$app->request->isPost){
            //接收提交过来的数据
            $post = Yii::$app->request->post();
            //调用方法
            if ($admin -> changepass($post)){

                Yii::$app->session->setFlash('info','密码修改成功!');
                Yii::$app->end();
            }
        }

        //显示设置新密码的模板
        $admin->admin_user =$admin_user;

        return $this->render('mailchangepass',['admin'=>$admin]);


    }

    /* 管理员列表 */
    public function actionList(){

        //取出数据
        $admin = Admin::find()->orderBy('id desc');

        //分页
        $count = $admin ->count();
        $pageSize = Yii::$app->params['pageSize']['manage'];//取到配置文件params.php里的分页信息;
        $pages = new Pagination(['totalCount'=>$count,'pageSize'=>$pageSize]);
        $data = $admin->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list',compact('data','pages'));

    }

    /* 添加新管理员 */
    public function actionAdd(){

        $admin = new Admin();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($admin ->add($post)){
                Yii::$app->session->setFlash('info','管理员添加成功!');
            }else{
                Yii::$app->session->setFlash('info','管理员添加是失败!');
            }
        }
        //避免界面表单中显示密码
        $admin ->admin_pass ='';
        $admin ->repass ='';
        return $this->render('add',compact('admin'));

    }

    /* 删除管理员 */
    public function actionDel(){

        $admin_id = (int)Yii::$app->request->get('admin_id');

        if(!empty($admin_id)){
            $re = Admin::deleteAll('id = :id',[':id'=>$admin_id]);
            if($re){
                Yii::$app->session->setFlash('info','删除成功!');
                $this -> redirect(['manage/list']);
            }else{
                Yii::$app->session->setFlash('info','删除失败1!');
                $this -> redirect(['manage/list']);
            }
        }
        $this -> redirect(['manage/list']);
    }

    /* 修改管理员邮箱 */
    public function actionChangeemail(){

        $admin = Admin::find()->where('admin_user=:user',[':user'=>Yii::$app->session['admin']['admin_user']])->one();

        if(Yii::$app->request->isPost){

            $post = Yii::$app->request->post();
            if($admin -> changeemail($post)){

                Yii::$app->session->setFlash('info','邮箱修改成功!');
            }
        }

        $admin->admin_pass = '';
        return $this->render('changeemail',compact('admin'));
    }

    /* 修改管理员密码 */
    public function actionChangepass(){

        $admin = Admin::find()->where('admin_user = :user',[':user'=>Yii::$app->session['admin']['admin_user']])->one();

        if(Yii::$app->request->isPost){
            $post = Yii::$app->request->post();
            if($admin -> changepass($post)){
                Yii::$app->session->setFlash('info','密码修改成功!');
            }
        }

        $admin ->admin_pass = '';
        return $this->render('changepass',compact('admin'));

    }


}